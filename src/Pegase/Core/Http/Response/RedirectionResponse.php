<?php

namespace Pegase\Core\Http\Response;

class RedirectionResponse implements ResponseInterface {
  
  private $url;
  private $code;

  public function __construct($url, $code = 302) {
    $this->url = $url;
    $this->code = $code;
  }

  public function set_url($url) {
    $this->url = $url;

    return $this;
  }

  public function get_url() {
    return $this->url;
  }

  public function set_code($code) {
    $this->code = $code;

    return $this;
  }

  public function get_code() {
    return $this->code;
  }

  public function send() {
    switch($this->code) {
      case 301:
        header('Status: 301 Moved Permanently', false, 301);
        break;
      case 302:
        header('Status: 301 Moved Temporarily', false, 302);
        break;
      default:
        break;
    }
    
    header('Location: ' . $this->url);
    exit;
  }
}

