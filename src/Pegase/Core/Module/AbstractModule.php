<?php

namespace Pegase\Core\Module;

abstract class AbstractModule {
 
  private $base_name;
  private $name;
  private $base_dir;
  private $path; // path of the module

  // boolean: are files, services, commands, and submodules loaded 
  private $submodules_loaded;

  public function __construct() {

    $this->name = "";
    $this->base_name = "";
    $this->base_dir = "";
    $this->submodules_loaded = false;

    $this->path = $this->get_path();

    if(strlen($this->path) > 0) {

      if($this->path[strlen($this->path) - 1] != "/")
        $this->path .= "/";
    }
  }

  public function load_submodules($sm) {

    if($this->submodules_loaded)
      return;

    $sub_modules = $this->get_submodules();//$this->get_commands();

    $module_manager = $sm->get('pegase.core.module_manager');
    
    $prefix = $this->get_real_name();
    
    if($prefix[strlen($prefix) - 1] != '/')
        $prefix .= '/';

    $prefix = str_replace('/', '\\', $prefix);

    foreach($sub_modules as $sub_module) {

      $name = explode('/', $sub_module);
      $name = end($name);

      $submodule_class = str_replace('/', '\\', 
        $prefix . $sub_module . '/' . $name . 'Module'
      );

      $submodule = new $submodule_class();
      
      $submodule->set_base_dir($this->get_real_path());
      $submodule->set_base_name($this->get_real_name() . '/');

      $module_manager->add($submodule);

      // on doit charger recursivement les sous modules
      $submodule->load_submodules($sm);
    }

    $this->submodules_loaded = true;

    return;
  }

  abstract public function get_name();

  public function get_path()
  {
    return "";
  }

  public function get_real_path()
  {
    $bd = $this->base_dir;
    $name = $this->path;

    if($name == "")
      $name = $this->get_name();

    $ret = "";
    $i = strlen($bd);

    if($i > 0) {
      if($bd[$i - 1] != '/')
        $bd .= '/';

      $ret = $bd;
    }

    $ret .= $name;
    
    $i = strlen($ret);
    
    if($ret[$i - 1] != '/')
      $ret .= '/';

    return $ret;
  }

  public function get_real_name()
  {
    $bn = $this->get_base_name();
    $name = $this->get_name();

    $ret = "";
    $i = strlen($bn);

    if($i > 0) {
      if($bn[$i - 1] != '/') // il sera changé après
        $bn .= '\\';

      $ret = $bn;
    }
    $ret .= $name;

    return $ret;
  }

  public function get_base_dir()
  {
    return $this->base_dir;
  }

  public function get_base_name()
  {
    return $this->base_name;
  }

  public function set_base_dir($base_dir)
  {
    $this->base_dir = $base_dir;
  }

  public function set_base_name($base_name)
  {
    $this->base_name = $base_name;
  }

  public function get_submodules() {
    return array();
  }

  public function get_parent() {
    return NULL;
  }
}

