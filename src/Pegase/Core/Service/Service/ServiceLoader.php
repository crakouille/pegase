<?php

namespace Pegase\Core\Service\Service;
use Pegase\Core\Service\Service\ServiceInterface;

class ServiceLoader implements ServiceInterface {
  
  private $sm;

  public function __construct($sm, $params = array()) {
    $this->sm = $sm;
  }

  public function load_from_yml($yml_file, $module = null) {
    $yaml = $this->sm->get('pegase.component.yaml.spyc');
    $module_manager = $this->sm->get('pegase.core.module_manager');

    if($module != null) {
      $yml_file = $module_manager->get_file($module, $yml_file);
    }
    else
      ; 

    $services = $yaml->parse($yml_file);

    foreach($services as $s_name => $s) {
      if(is_array($s)) {

        if(key_exists('import', $s)) {
          $this->load_from_yml($s['import']['file'], $s['import']['module']);
        }
        else if(key_exists('class', $s) && key_exists('parameters', $s)) {
         
          //echo "Ajout de ", $s_name, "<br />";
  
          $this->sm->set_service_known($s_name, array(
            $s['class'], 
            $s['parameters']
          ));
        }
      }
      else var_dump($s);
    }
    // end foreach
  }
}

