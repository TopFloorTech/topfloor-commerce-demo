<?php

namespace Drupal\workwise_commerce\Plugin\WorkWise;

use Drupal\commerce_order\Entity\OrderInterface;
use Drupal\commerce_order\Entity\OrderItemInterface;
use Drupal\Core\Annotation\ContextDefinition;
use Drupal\Core\Annotation\Translation;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Render\Markup;
use Drupal\workwise\Annotation\WorkWisePlugin;
use Drupal\workwise\Plugin\WorkWise\CrudPluginBase;
use Drupal\workwise\WorkWise\ApiRequest\ApiRequestInterface;

/**
 * Provides a 'Commerce order' WorkWise plugin.
 *
 * @WorkWisePlugin(
 *   id = "commerce_order",
 *   label = @Translation("Commerce order"),
 *   requirements = {
 *     "modules" = {
 *       "commerce_order",
 *     },
 *   },
 *   entity_type = "commerce_order",
 *   context = {
 *     "workwise_integration" = @ContextDefinition("entity:workwise_integration", label = @Translation("WorkWise integration"))
 *   }
 * )
 */
class WorkWiseCommerceOrderPlugin extends CrudPluginBase {

  protected $productRemoteIdField = 'field_workwise_id';
  protected $userRemoteIdField = 'field_workwise_id';
  protected $profileRemoteIdField = 'field_workwise_id';

  protected $workWiseOrderType = 1; // 1 = Written order

  public function defaultConfiguration() {
    $defaultConfiguration = parent::defaultConfiguration();
    $defaultConfiguration['order_taken_by_id'];

    return $defaultConfiguration;
  }

  public function buildConfigurationForm(array $form, FormStateInterface $form_state) {
    $form = parent::buildConfigurationForm($form, $form_state);

    $configuration = $this->getConfiguration();

    $form['order_taken_by_id'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Order taken by'),
      '#description' => $this->t('The WorkWise user ID to attribute this order to.'),
      '#default_value' => $configuration['order_taken_by_id'],
    ];

    return $form;
  }

  public function submitConfigurationForm(array &$form, FormStateInterface $form_state) {
    parent::submitConfigurationForm($form, $form_state);

    $values = $form_state->getValue($this->getConfigurationFormStateKey(), []);
    $this->configuration['order_taken_by_id'] = $this->getValue('order_taken_by_id', $values);
  }

  /**
   * {@inheritdoc}
   */
  public function getApiMethods() {
    return [
      'create' => 'CreateCustomerOrder',
      'read' => NULL,
      'update' => NULL,
      'delete' => NULL,
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function prepareRequestData($operation, EntityInterface $entity = NULL) {
    $data = [];
    $configuration = $this->getConfiguration();

    if ($operation === 'create' && $entity instanceof OrderInterface) {
      $data['Header'] = [
        'ID_ORD_WEB' => $entity->getOrderNumber(),
        'ID_CUST_SOLDTO' => $this->getCustomerRemoteId($entity),
        'SEQ_SHIPTO' => $this->getShippingProfileRemoteId($entity),
        'TYPE_ORD_CP' => $this->workWiseOrderType,
        //'DATE_ORD' => date('Y-m-d H:i:s', $entity->getPlacedTime()), // @todo Check format and uncomment
        'ID_USER_ORD' => $configuration['order_taken_by_id'],
        'AMT_FRT' => $this->getShippingPrice($entity),
        'TAX_SLS' => $this->getSalesTaxPrice($entity),
      ];

      $data['Lines'] = $this->getWorkWiseLineItems($entity);
    }

    return $data;
  }

  private function getCustomerRemoteId(OrderInterface $order) {
    $customer = $order->getCustomer();
    $customerId = '';
    if ($customer->hasField($this->userRemoteIdField) && !$customer->get($this->userRemoteIdField)->isEmpty()) {
      $customerId = $customer->get($this->userRemoteIdField)->value;
    }
    return $customerId;
  }

  private function getShipment(OrderInterface $order) {
    $firstShipment = NULL;

    if ($order->hasField('shipments') && !$order->get('shipments')->isEmpty()) {
      /** @var \Drupal\Core\Field\EntityReferenceFieldItemListInterface $shipmentsField */
      $shipmentsField = $order->get('shipments');
      $shipments = $shipmentsField->referencedEntities();
      /** @var \Drupal\commerce_shipping\Entity\ShipmentInterface $firstShipment */
      $firstShipment = reset($shipments);
    }

    return $firstShipment;
  }

  private function getShippingProfileRemoteId(OrderInterface $order) {
    // @todo Don't hardcode this once we can select an existing profile during checkout
    return '10100-0000';

    $profileId = NULL;

    $shipment = $this->getShipment($order);

    if ($shipment
      && $shipment->getShippingProfile()->hasField($this->profileRemoteIdField)
      && !$shipment->getShippingProfile()->get($this->profileRemoteIdField)->isEmpty()) {
      $profileId = $shipment->getShippingProfile()->get($this->profileRemoteIdField)->value;
    }

    return $profileId;
  }

  private function getWorkWiseLineItems(OrderInterface $order) {
    $lines = [];

    foreach ($order->getItems() as $index => $orderItem) {
      $lines[] = [
        'SEQ_LINE_ORD' => $index + 1,
        'ID_ITEM' => $this->getProductRemoteId($orderItem),
        'QTY_OPEN' => $orderItem->getQuantity(),
        'PRICE_SELL_NET_VP_FC' => $orderItem->getTotalPrice()->getNumber(),
      ];
    }

    return $lines;
  }

  private function getProductRemoteId(OrderItemInterface $orderItem) {
    $remoteId = NULL;

    /** @var \Drupal\commerce_product\Entity\ProductVariationInterface $productVariation */
    $productVariation = $orderItem->getPurchasedEntity();

    if ($productVariation
      && $productVariation->hasField($this->productRemoteIdField)
      && !$productVariation->get($this->productRemoteIdField)->isEmpty()) {
      $remoteId = $productVariation->get($this->productRemoteIdField)->value;
    }

    return $remoteId;
  }

  private function getShippingPrice(OrderInterface $order) {
    $shipment = $this->getShipment($order);
    return $shipment->getAmount()->getNumber();
  }

  private function getSalesTaxPrice(OrderInterface $order) {
    // @todo Return actual sales tax once we're calculating it.
    return "0.00";
  }

  /**
   * {@inheritdoc}
   */
  public function handleResponse($operation, ApiRequestInterface $request, EntityInterface $entity = NULL) {
    if ($operation === 'create' && $entity instanceof OrderInterface) {
      $responseCode = $request->getResponseCode();

      if ($responseCode == 0) {
        $response = $request->getResponseData();
        if ($response['ID_ORD']) {
          $entity->get($this->remoteIdField)->value = $response['ID_ORD'];
          $entity->save();
        }
      } else {
        \Drupal::messenger()->addMessage(Markup::create('WorkWise error: ' . $request->getErrorMessage()));
      }
    }
  }

  public function validateOperation($operation, EntityInterface $entity = NULL) {
    $valid = parent::validateOperation($operation, $entity);

    if ($valid) {
      $valid = !empty($entity)
        && $entity instanceof OrderInterface
        && $entity->hasField($this->remoteIdField);
    }

    if ($valid) {
      if ($operation === 'create') {
        $valid = $entity->hasItems()
          && !$entity->cart->value
          && $entity->getPlacedTime()
          && $entity->get($this->remoteIdField)->isEmpty();
      } elseif ($operation === 'read' || $operation === 'delete') {
        $valid = !$entity->get($this->remoteIdField)->isEmpty();
      } elseif ($operation === 'update') {
        $valid = !$entity->cart->value
          && $entity->getPlacedTime()
          && !$entity->get($this->remoteIdField)->isEmpty();
      }
    }

    return $valid;
  }

}
