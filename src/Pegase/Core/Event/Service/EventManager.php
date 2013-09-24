<?php

namespace Pegase\Core\Event\Service;

use Pegase\Core\Service\Service\ServiceInterface;
use Pegase\Core\Event\Service\EventListenerLoader;

class EventManager implements ServiceInterface {

  private $sm;
  //private $loader;
  private $listeners; // listeners registered
  
  public function __construct($sm, $params) {
    $this->sm = $sm;
    $this->listeners = array();

    //$this->loader = $sm->get('pegase.core.event_loader');
    //Ne pas faire ceci: les 2 services dépendent l'un de l'autre,
    //et s'intancient indéfiniment.
    //Pour y remédier, il faut créer ce service dans l'autre, en lui 
    // donnant $this comme argument. Puis on enregistre le service.
    //$this->loader = new EventListenerLoader($sm, array($this));
    //$sm->set('pegase.core.event_loader', $this->loader);

    // Le choix adopté est différent: avoir les 2 services dans le .yml
    // et ne pas faire de get(service) dans l'un des 2 constructeurs.
    // mais éventuellement à chaque début de fonction.
  }

  // send:
  // @event: peut être n'importe quoi

  public function send($event) { 

    $response = $this->sub_send('event:pre_call', $event);
    
    if($response == null)
      $response = $this->sub_send($event->get_event_name(), $event);

    if($response == null)
      $response = $this->sub_send('event:post_call', $event);

    return $response;
  }

  private function sub_send($event_name, $event) { 
    
    $response = null;

    if(key_exists($event_name, $this->listeners)) {
      
      foreach($this->listeners[$event_name] as $listener) {
        //$listener->listen($event_name, $event);
        $response = call_user_func_array(array($listener[1], $listener[0]), array($event));
        // $listener[1] -> the instance
        // $listener[0] -> the method name
        
      }
    }

    return $response;
  }

  public function register($event_name, $method_name, $listener) {

    if(key_exists($event_name, $this->listeners)) {
      array_push(array($method_name, $listener), $this->listeners[$event_name]);
    }
    else {
      $this->listeners[$event_name] = array(array($method_name, $listener));
    }
  }
}


