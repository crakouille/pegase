<?php

namespace Pegase\Core\Http\Response;

class Response implements ResponseInterface {
  
  private $content;

  public function __construct() {
    $this->content = "";
  }

  public function write($text) {
    $this->content .= $text;
  }

  public function get_content() {
    return $this->content;
  }

  public function send() {
    echo $this->content;
  }
}
