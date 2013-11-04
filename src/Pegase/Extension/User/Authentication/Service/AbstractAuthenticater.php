<?php

namespace Pegase\Extension\User\Authentication\Service;

use Pegase\Core\Service\Service\ServiceInterface;

abstract class Authenticater implements ServiceInterface {

  private $sm;
  private $params;
  private $current_user; // the user loaded

  public function __construct($sm, $params = array())
  {
    $this->sm = $sm;
    $this->user = null;

    if($params == null)
      $params = array();

    if(!key_exists('session_var', $params))
      $params['session_var'] = 'pegase.extension.user.user';
    // Paramètres:
    // session_var_name: La variable de session dans laquelle on stocke les infos de connexion
    
    $this->params = $params;
    $this->current_user = $this->get_user();
  }

  public function get_user();
  public function set_user($user);
  public function unset_user();

}
