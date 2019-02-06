<?php

namespace Drupal\workwise\WorkWise\ApiRequest;

interface ApiRequestInterface {
  public function getApiMethod();

  public function getRequestData();

  public function sendRequest();

  public function isSent();

  public function getResponseCode();

  public function getResponseData();
}
