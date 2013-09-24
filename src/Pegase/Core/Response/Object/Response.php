<?php

namespace Pegase\Core\Response\Object;

class Response {
  
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
