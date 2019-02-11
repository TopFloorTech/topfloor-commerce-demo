<?php

namespace Drupal\workwise\WorkWise\ApiRequest;

interface ApiRequestInterface {
  public function getApiMethod();

  public function getRequestData();

  public function sendRequest();

  public function isSent();

  public function getResponseCode();

  public function getErrorMessage();

  public function getResponseData();

  public function debugRequestInfo();

  public function debugResponseInfo();

  public function isDryRun();

  public function setDryRun($dryRun);

}
