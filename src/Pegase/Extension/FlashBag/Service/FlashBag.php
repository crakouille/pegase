<?php

namespace Pegase\Extension\FlashBag\Service;

use Pegase\Core\Service\Service\ServiceInterface;

class FlashBag implements ServiceInterface
{
  private $infos;
  private $session_name;

  public function __construct($sm, $params) {

    if(is_array($params) && key_exists("session_var", $params))
      $this->session_name = $params["session_var"];
    else
      $this->session_name = "pegase.extension.flashbag";

    if(key_exists($session_name, $_SESSION)) {
      $this->infos = unserialize($_SESSION[$session_name]);
    }
    else {
      $this->infos = array();
    }
  }

  public function __destruct() {
    $_SESSION[$this->session_name] = serialize($this->infos);
  }

  public function add($info_category, $content) {

    if(key_exists($info_category, $this->infos)) {
      array_push($this->infos[$info_category], $content);
    }
    else {
      $this->infos[$info_category] = array($content);
    }

    return $this;
  }

  /*
    
  */

  public function get($info_category) {
    $ret = null;

    if(key_exists($info_category, $this->infos)) {
      $ret = array_shift($this->infos[$info_category]);

      if(count($this->infos[$info_category]) == 0) {
        unset($this->infos[$info_category]);
      }
    }
  
    return $ret;
  }
}

