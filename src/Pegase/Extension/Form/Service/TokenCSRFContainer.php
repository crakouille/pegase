<?php

namespace Pegase\Extension\Form\Service;

use Pegase\Core\Service\Service\ServiceInterface;
use Pegase\Extension\Form\Token\TokenCSRF;

class TokenCSRFContainer implements ServiceInterface {
  
  private $sm;
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

  public function __construct($sm, $params) {

    $this->sm = $sm;
    $this->tokens = array();
  }

  public function load() {

    // $_SESSION['pegase.core.security.form.csrf'] = array();

    if(key_exists('pegase.core.security.form.csrf', $_SESSION)) {

      foreach($_SESSION['pegase.core.security.form.csrf'] as $d) {
        $this->tokens[$d] = new TokenCSRF($d);
      }

      //$this->tokens = array();
 
     /* foreach($this->tokens as $t) {
        echo $t->get_id(), "<br />";
      }*/
    }

    return;
  }

  public function generate()
  {
    $token = new TokenCSRF($this->generate_id());

    $this->set($token);

    return $token;
  }

  public function generate_id() {

    $l = count(self::$caracters);

    do {

      $id = "";
      
      for($i = 0; $i < 15; $i++) {
        $n = rand(0, $l - 1);
        $id .= self::$caracters[$n];
      }
      
    } while(key_exists($id, $this->tokens));

    return $id;
  }

  public function set($token) {

    $this->tokens[$token->get_id()] = $token;

    return $this;
  }

  public function get($token_id) {

    if(key_exists($token_id, $this->tokens)) { 
      $token = $this->tokens[$token_id];
      
    }
    else {
      $token = null;//echo "<pre>";
      //var_dump($this->tokens);echo "</pre>";
    }

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
    //$_SESSION['pegase.core.security.form.csrf'] = $this->tokens;
    $_SESSION['pegase.core.security.form.csrf'] = array();

    foreach($this->tokens as $d) {
      $_SESSION['pegase.core.security.form.csrf'][] = $d->get_id();
    }
  }

  public function is_valid($token_id) {

    $token = $this->get($token_id);

    if(!$token)
      return false;

    return $token->is_valid();
  }
}

