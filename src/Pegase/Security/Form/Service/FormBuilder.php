<?php

namespace Pegase\Security\Form\Service;

use Pegase\Core\Service\Service\ServiceInterface;

class FormBuilder implements ServiceInterface {
  
  private $sm;

  public function __construct($sm, $params) {

    $this->sm = $sm;

    /*if(key_exists('pegase.core.security.form.csrf', $_SESSION))
      $this->tokens = $_SESSION['pegase.core.security.form.csrf'];
    else
      $this->tokens = array();*/
  }

  // generate a form
  public function generate($target, $type = 'post') {
    
    $form = new \Pegase\Security\Form\Objects\Form(
      $target,
      $this->sm->get('pegase.security.token_csrf_container'), 
      $type);
    
    return $form;
  }
  
}
