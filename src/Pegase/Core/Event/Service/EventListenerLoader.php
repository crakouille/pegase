<?php

namespace Pegase\Core\Event\Service;

use Pegase\Core\Service\Service\ServiceInterface;
use Pegase\Core\Event\Service\EventManager;

class EventListenerLoader implements ServiceInterface {
  
  private $sm;
  private $em; // event manager

  public function __construct($sm, $params = array()) {
    $this->sm = $sm;
    //$this->em = $params[0];
    $this->em = $sm->get('pegase.core.event_manager');
    //Ne pas faire ceci si les 2 services dépendent l'un de l'autre,
    //et s'intancient indéfiniment.
    //Pour y remédier, il faut créer ce service dans l'autre, en lui 
    // donnant $this comme argument. Puis on enregistre le service.
  }

  public function load_from_yml($yml_file) {
    $yaml = $this->sm->get('pegase.component.yaml.spyc');
    $event_listeners = $yaml->parse($yml_file);

    foreach($event_listeners as $el_name => $el) {

      $event_listener = new $el['class']($this->sm, $el['parameters']);
      $this->em->register($el['event'], $el['method'], $event_listener);
    }
  }
}

