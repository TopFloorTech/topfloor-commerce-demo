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
   * Retrieves the entity type ID associated with this plugin.
   *
   * @return string|NULL
   *   The entity type ID, or NULL if this plugin doesn't relate to an entity type.
   */
  public function getEntityTypeId();

  /**
   * Retrieves the form state key from the parent form containing the configuration for this plugin.
   *
   * @return string
   *   The form state key, or NULL if there is no configuration for this plugin.
   */
  public function getConfigurationFormStateKey();

  /**
   * Retrieves the plugin's requirements.
   *
   * @return array
   *   The requirements keyed by requirement type (e.g. "modules", "plugins").
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
   * @param string $operation
   *   The operation that the data will be used for.
   * @param \Drupal\Core\Entity\EntityInterface|NULL $entity
   *   The entity to get the data from.
   *
   * @return array
   *   A structured array of data representing the provided entity.
   */
  public function prepareRequestData($operation, EntityInterface $entity = NULL);

  /**
   * Allows the plugin to take action based on the API response.
   *
   * If the attempted operation was not successful, and cannot be handled
   *   adequately, a WorkWiseException should be thrown.
   *
   * @param string $operation
   *   The type of operation that was requested from the API.
   * @param \Drupal\workwise\WorkWise\ApiRequest\ApiRequestInterface $request
   *   The request object that contains the response data.
   * @param \Drupal\Core\Entity\EntityInterface|null $entity
   *   The entity the request was acting on, if available.
   *
   * @return void
   */
  public function handleResponse($operation, ApiRequestInterface $request, EntityInterface $entity = NULL);

  /**
   * Gets an array of labels for each operation keyed by the operation ID.
   *
   * @return string[]
   */
  public function getOperationDefinitions();

  /**
   * Validates that this plugin can perform the requested operation, optionally
   * against the supplied entity.
   *
   * @param $operation
   *   The name of the operation.
   * @param EntityInterface|null $entity
   *
   *
   * @return bool
   *   TRUE if the operation should proceed, FALSE otherwise.
   */
  public function validateOperation($operation, EntityInterface $entity = NULL);

  /**
   * Retrieve the remote ID for a given entity if possible.
   *
   * @param \Drupal\Core\Entity\EntityInterface $entity
   *   The entity whose data to retrieve the remote ID for.
   *
   * @return string|NULL
   *   The remote ID, or NULL if there is no remote ID or it doesn't exist yet.
   */
  public function getRemoteId(EntityInterface $entity);

}
