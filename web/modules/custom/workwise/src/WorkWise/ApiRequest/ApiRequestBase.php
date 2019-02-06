<?php

namespace Drupal\workwise\WorkWise\ApiRequest;

class ApiRequestBase implements ApiRequestInterface {

  protected $connectionInfo;

  protected $apiMethod;

  protected $data;

  protected $sent = FALSE;

  protected $response;

  public function __construct($connectionInfo, $apiMethod, $data = []) {
    $this->connectionInfo = $connectionInfo;
    $this->apiMethod = $apiMethod;
    $this->data = $data;
  }

  public function getApiMethod() {
    return $this->apiMethod;
  }

  public function getRequestData() {
    return $this->data;
  }

  protected function prepareRequest() {
    $request = [];

    $request['Credential'] = [
      'Company' => $this->connectionInfo['company'],
      'Username' => $this->connectionInfo['username'],
      'Password' => $this->connectionInfo['password'],
    ];

    $request['Filters'] = $this->getRequestData();

    return $request;
  }

  public function sendRequest() {
    $result = \Drupal::httpClient()->post($this->connectionInfo['url'], [
      'json' => $this->prepareRequest(),
    ]);

    $this->response = json_decode($result->getBody(), TRUE);
    $this->sent = TRUE;
  }

  public function isSent() {
    return $this->sent;
  }

  public function getResponseCode() {
    if (!isset($this->response['Status']['ErrorCode'])) {
      return NULL;
    }

    return (int) $this->response['Status']['ErrorCode'];
  }

  public function getResponseMessage() {
    if (!isset($this->response['Status']['Message'])) {
      return NULL;
    }

    return $this->response['Status']['Message'];
  }

  public function getResponseData() {
    if (!isset($this->response['Records'])) {
      return [];
    }

    return $this->response['Records'];
  }
}
