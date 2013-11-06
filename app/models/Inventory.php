<?php

class Inventory extends \Adamgoose\PrismicIo\Model {
  public $collection = 'inventory';
  public $pageSize = 99;

  public function configure($endpoint, $token)
  {
    $this->endpoint = $endpoint;
    $this->token = $token;

    return $this;
  }
}