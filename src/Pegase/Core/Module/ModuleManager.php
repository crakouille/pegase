<?php

namespace Pegase\Core\Module;

use Pegase\Core\Exception\Objects\PegaseException;
use Pegase\Core\Service\Service\ServiceInterface;

class ModuleManager implements ServiceInterface {

  private $sm;
  private $modules; 

  public function __construct($sm, $modules) {
    $this->sm = $sm;
    $this->add_modules($modules);
  }

  public function load_submodules($sm) {
    foreach($this->modules as $module)
      $module->load_submodules($sm);
  }

  public function add($module) {

    $this->modules[$module->get_real_name()] = $module;
  }

  public function add_modules($modules) {
    foreach($modules as $m) {
      $this->add($m);
    }
  }

  public function get_modules() {
    return $this->modules;
  }

  //

  public function get_file($module_name, $filename) { // avec gestion de l'héritage
    
    if(!key_exists($module_name, $this->modules))
      throw new PegaseException($module_name . " is not a know module.");

    $module = $this->modules[$module_name];

    $path = $this->sm->get('pegase.core.path');
    $p = $module->get_real_path() . $filename;
    
    echo $path->get_path($p), "<br />";

    if(!file_exists($path->get_path($p))) {
      // si fichier non existant
      $p = $module->get_parent();

      if($p != NULL) {
        return $this->get_file($p, $filename);
      }
      else {
        return NULL;
      }
    }

    return $p;
  }
}

