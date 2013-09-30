<?php

namespace Pegase\Core\Event\Loader;

use Pegase\Core\Service\Service\ServiceInterface;
use Pegase\Core\Event\Service\EventManager;

use Pegase\Core\Exception\Objects\PegaseException;

class EventListenerLoader implements ServiceInterface {
  
  private $sm;
  private $em; // event manager

  public function __construct($sm, $params = array()) {
    $this->sm = $sm;
    $this->em = null;
  }

  public function set_service($em) {
    $this->em = $em;

    return $this;
  }

  /*public function load_from_yml($yml_file) {
    $yaml = $this->sm->get('pegase.component.yaml.spyc');
    $event_listeners = $yaml->parse($yml_file);

    foreach($event_listeners as $el_name => $el) {

      $event_listener = new $el['class']($this->sm, $el['parameters']);
      $this->em->register($el['event'], $el['method'], $event_listener);
    }
  }*/

  public function load_from_yml($yml_file, $module = null) {
    $yaml = $this->sm->get('pegase.component.yaml.spyc');
    $module_manager = $this->sm->get('pegase.core.module_manager');

    if($module != null) {
      $yml_file1 = $yml_file;
      $yml_file = $module_manager->get_file($module, $yml_file);

      if($yml_file == null)
        throw new PegaseException("File " . $yml_file1 . " doesn't exists in module " . $module );
    }
    else
      ;

    if($yml_file == null)
      return;

    $assets = $yaml->parse($yml_file);

    foreach($assets as $a_name => $s) {
      if(is_array($s)) {

        if(key_exists('import', $s)) {
          $this->load_from_yml($s['import']['file'], $s['import']['module']);
        }
        else if(key_exists('class', $s) && 
                key_exists('method', $s) &&
                key_exists('event', $s) &&
                key_exists('parameters', $s)) {
  
          $event_listener = new $s['class']($this->sm, $s['parameters']);
          $this->em->register($s['event'], $s['method'], $event_listener);
        }
        
        else {
          ob_start();
          var_dump($s);
          $result = ob_get_clean();

          throw new PegaseException($result . 
 " should contain the 'class', 'method', 'event' and 'parameters' fields, or the 'import' field.");
        }
      }
      else
        throw new PegaseException($s . "should be an Array."); 
    }
    // end foreach
  }
}

