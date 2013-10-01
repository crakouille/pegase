<?php

namespace Pegase\Extension\Form\Token;

use Pegase\Security\Form\Objects\FormView;

class TokenCSRF {
 
  private $id;
  
  public function __construct($id) {
    $this->id = $id;
  }

  public function is_valid() {

    // il faudra stocker le chemin de la page dans laquelle est le formulaire
    // et regarder $_SERVER['HTTP_REFERER']
    // solution potentiellement non viable: http_referer renseigné par le navigateur

    return true;
  }

  public function get_id() {
    return $this->id;
  }
}
