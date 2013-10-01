<?php

namespace Pegase\Core\Module\Loader;

use Pegase\Core\Service\Service\ServiceInterface;
use Pegase\Core\Event\Service\EventManager;

use Pegase\Core\Exception\Objects\PegaseException;

class ModuleLoader implements ServiceInterface {
  
  private $sm;
  private $mm; // event manager

  public function __construct($sm, $params = array()) {
    $this->sm = $sm;
    $this->mm = null;
  }

  public function set_service($mm) {
    $this->mm = $mm;

    return $this;
  }

  public function load_from_yml($yml_file, $module = null) {
    $yaml = $this->sm->get('pegase.component.yaml.spyc');
    $module_manager = $this->sm->get('pegase.core.module_manager');

    if($module != null) {
      echo $yml_file1;
      $yml_file1 = $yml_file;
      $yml_file = $module_manager->get_file($module, $yml_file);

      if($yml_file == null)
        throw new PegaseException("File " . $yml_file1 . " doesn't exists in module " . $module );
    }
    else
      ;

    if($yml_file == null)
      return;

    $modules = $yaml->parse($yml_file);

    foreach($modules as $s_name => $s) {
      if(is_array($s)) {

        if(key_exists('import', $s)) {
          $this->load_from_yml($s['import']['file'], $s['import']['module']);
        }
        else {
          ob_start();
          var_dump($s);
          $result = ob_get_clean();

          throw new PegaseException($result . 
 " should contain the 'class', 'method', 'event' and 'parameters' fields, or the 'import' field.");
        }
      }
      else {
        $module = new $s();
        $this->mm->add($module);
      }
    }
    // end foreach
  }
}

