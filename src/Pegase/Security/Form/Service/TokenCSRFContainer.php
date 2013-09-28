<?php

namespace Pegase\Security\Form\Token;

use Pegase\Core\Service\Service\ServiceInterface;

class TokenCSRFContainer implements ServiceInterface {
  
  private $tokens;

  static private $caracters = array(
    '0','1','2','3','4','5','6','7',
    '8','9','a','b','c','d','e','f',
    'g','h','i','j','k','l','m','n',
    'o','p','q','r','s','t','u','v',
    'w','x','y','z','A','B','C','D',
    'E','F','G','H','I','J','K','L',
    'M','N','O','P','Q','R','S','T',
    'U','V','W','X','Y','Z'
  );

  public function __construct() {

    if(key_exists('pegase.core.security.form.csrf', $_SESSION))
      $this->tokens = $_SESSION['pegase.core.security.form.csrf'];
    else
      $this->tokens = array();
  }

  public function generate_id() {

    $l = strlen($this->caracters);

    do {

      $id = "";
      
      for($i = 0; $i < 15; $i++) {
        $n = rand(0, $l - 1);
        $id .= $caracters[$n];
      }
      
    } while(key_exists($id, $this->tokens));

    return $id;
  }

  public function set($token) {

    $this->tokens[$token->get_id()] = $token;

    return $this;
  }

  public function get($token_id) {

    if(key_exists($token->get_id(), $this->tokens)) 
      $token = $this->tokens[$token_id]);
    else
      $token = null;

    return $token;
  }

  public function remove($token) {

    if(key_exists($token->get_id(), $this->tokens)) 
      unset($this->tokens[$token->get_id()]);
    else
      ;

    return $this;
  }

  public function save() {
    $_SESSION['pegase.core.security.form.csrf'] = $this->tokens;
  }
}
