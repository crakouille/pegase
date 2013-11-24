<?php

namespace Pegase\Core\Module\Service;

use Pegase\Core\Exception\Objects\PegaseException;
use Pegase\Core\Service\Service\ServiceInterface;

use Pegase\Core\Module\Loader\ModuleLoader;

class ModuleManager implements ServiceInterface {

  private $sm;
  private $modules;
  private $loader;

  public function __construct($sm, $modules = array()) {
    $this->sm = $sm;
    $this->add_modules($modules);

    $this->loader = new ModuleLoader($sm);
    $this->loader->set_service($this);
  }

  public function load() {
    $this->loader->load_from_yml('app/config/modules.yml');
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
      throw new PegaseException($module_name . " is not a know module: You should register it in app/Modules.php or declare it as submodule of another of your modules.");

    $module = $this->modules[$module_name];

    $path = $this->sm->get('pegase.core.path');
    $p = $module->get_real_path() . $filename;

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

  public function get_path($module_name, $filename) { // sans gestion de l'héritage
    
    if(!key_exists($module_name, $this->modules))
      throw new PegaseException($module_name . " is not a know module: You should register it in app/Modules.php or declare it as submodule of another of your modules.");

    $module = $this->modules[$module_name];

    $path = $this->sm->get('pegase.core.path');
    $p = $module->get_real_path() . $filename;

    echo $module->get_real_path(), "\n";

    return $p;
  }
}

