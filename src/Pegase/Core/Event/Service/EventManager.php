<?php

namespace Pegase\Core\Event\Service;

use Pegase\Core\Service\Service\ServiceInterface;
use Pegase\Core\Event\Loader\EventListenerLoader;

class EventManager implements ServiceInterface {

  private $sm;
  //private $loader;
  private $listeners; // listeners registered
  
  public function __construct($sm, $params) {
    $this->sm = $sm;
    $this->listeners = array();

    $this->loader = new EventListenerLoader($sm);

    $this->loader->set_service($this);
    $this->loader->load_from_yml('app/config/event_listeners.yml');
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
      array_push($this->listeners[$event_name], array($method_name, $listener));
    }
    else {
      $this->listeners[$event_name] = array(array($method_name, $listener));
    }
  }
}


