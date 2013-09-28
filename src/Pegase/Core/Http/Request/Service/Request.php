<?php

namespace Pegase\Core\Http\Request\Service;
use Pegase\Core\Service\Service\ServiceInterface;

class Request implements ServiceInterface {

  private $sm;
  private $uri;
  //private $method;
  
  public function __construct($sm, $params) {
    $this->sm = $sm;
    $this->uri = $_SERVER['REQUEST_URI'];

    $pos = stripos($this->uri, '/index.php');

    if((null != $pos) && ($pos == 0))
      $this->uri = substr($this->uri, strlen('/index.php') - 1);
  }

  public function get_uri() {
    return $this->uri;
  }

  public function get_method() {
    return $_SERVER['REQUEST_METHOD']; //$this->method;
  }
}

