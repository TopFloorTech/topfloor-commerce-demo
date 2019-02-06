<?php

namespace Drupal\workwise\Plugin\WorkWise;

use Drupal\Component\Plugin\ConfigurablePluginInterface;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\FieldableEntityInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\Plugin\ContextAwarePluginInterface;
use Drupal\Core\Plugin\PluginFormInterface;
use Drupal\Core\TypedData\TypedDataInterface;
use Drupal\workwise\WorkWise\ApiRequest\ApiRequestInterface;

/**
 * Represents a plugin for WorkWise connections.
 */
interface WorkWisePluginInterface extends ConfigurablePluginInterface, ContainerFactoryPluginInterface, ContextAwarePluginInterface, PluginFormInterface {

  /**
   * Retrieves the plugin's label.
   *
   * @return string
   *   The plugin's human-readable and translated label.
   */
  public function label();

  /**
   * Retrieves the plugin's description.
   *
   * @return string|null
   *   The plugin's translated description; or NULL if it has none.
   */
  public function getDescription();

  /**
   * Retrieves the plugin's requirements.
   *
   * @return array
   *   The requirements keyed by requirement type (e.g. "modules").
   */
  public function getRequirements();

  /**
   * Validates whether the requirements for this plugin have been met.
   *
   * @return bool
   *   TRUE if the requirements have been met, FALSE otherwise.
   */
  public function validateRequirements();

  /**
   * Gets the API methods that this plugin will utilize for CRUD operations.
   *
   * Format:
   *
   * [
   *   'create' => 'CreateCustomerOrder',
   *   'read' => 'GetCustomerOrder',
   *   'update' => 'UpdateCustomerOrder',
   *   'delete' => 'DeleteCustomerOrder',
   * ]
   *
   * @return string[]
   *   The API methods this plugin utilizes.
   */
  public function getApiMethods();

  /**
   * Gets the API method name for a specific operation if available.
   *
   * @param string $operation
   *   The operation (create, read, update, or delete)
   *
   * @return string|NULL
   *   The name of the API method, or NULL if there is no API method for this plugin.
   */
  public function getApiMethod($operation = 'read');

  /**
   * Translates the provided entity into a dataset that can be sent to the API.
   *
   * @param \Drupal\Core\Entity\EntityInterface $entity
   *   The entity to get the data from.
   *
   * @param string $operation
   *   The operation that the data will be used for.
   *
   * @return array
   *   A structured array of data representing the provided entity.
   */
  public function prepareRequestData(EntityInterface $entity, $operation = 'create');

  /**
   * Allows the plugin to take action based on the API response.
   *
   * If the attempted operation was not successful, and cannot be handled
   *   adequately, a WorkWiseException should be thrown.
   *
   * @param \Drupal\workwise\WorkWise\ApiRequest\ApiRequestInterface $request
   *   The request object that contains the response data.
   *
   * @param string $operation
   *   The type of operation that was requested from the API.
   *
   * @return void
   */
  public function handleResponse(ApiRequestInterface $request, $operation = 'create');
}
