<?php

namespace Pegase\Extension\User\Authentication\EventListener;

use Pegase\Core\Event\Listener\EventListenerInterface;
use Pegase\Core\Exception\Object\PegaseException;

class AuthenticationListener implements EventListenerInterface {

  private $sm;
  private $params;

  public function __construct($sm, $params) {
    $this->sm = $sm;
    $this->params = (is_array($params) ? $params : array());

    if(!key_exists("authenticater", $this->params)) {
      throw new PegaseException("'authenticater' field required");
    }
  }

  public function auth_listen() {
    $this->sm->get($this->params["authenticater"]);
  }
}
