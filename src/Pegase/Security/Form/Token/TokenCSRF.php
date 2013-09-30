<?php

namespace Pegase\Security\Form\Token;

use Pegase\Security\Form\Objects\FormView;

class TokenCSRF {
 
  private $id;
  
  public function __construct($id) {
    $this->id = $id;
  }

  public function is_valid() {

    if($_SERVER['SERVER_ADDR'] != $_SERVER['REMOTE_ADDR'])
      return false;

    return true;
  }

  public function get_id() {
    return $this->id;
  }
}
