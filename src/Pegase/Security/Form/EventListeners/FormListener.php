<?php

namespace Pegase\Security\Form\EventListeners;

use Pegase\Core\Event\Listener\EventListenerInterface;

class FormListener implements EventListenerInterface {
  
  private $sm;

  public function __construct($sm, $params) {

    $this->sm = $sm;
  }

  // generate a form
  public function load_tokens() {
    $c = $this->sm->get('pegase.security.token_csrf_container');

    $c->load();

    return;
  }

  public function save_tokens() {

    $c = $this->sm->get('pegase.security.token_csrf_container');

    $c->save();

    return;
  }
  
}
