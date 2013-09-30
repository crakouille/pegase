<?php

namespace Pegase\Core\Router\Loader;
use Pegase\Core\Service\Service\ServiceInterface;

use Pegase\Core\Exception\Objects\PegaseException;

class RouteLoader {
  
  private $sm;
  private $sr;
  private $router;

  public function __construct($sm) {
    $this->sm = $sm;
  }

  public function set_service($sr) {
    $this->router = $sr;
  }

  public function load_from_yml($yml_file, $module = null, $prefix = "") {
    $yaml = $this->sm->get('pegase.component.yaml.spyc');
    $module_manager = $this->sm->get('pegase.core.module_manager');

    $n = strlen($prefix) - 1;
    if($n >= 0) {
      if($prefix[$n] == '/')
        $prefix = substr($prefix, 0, $n);
      else;
    }
    else {
      $prefix = "";
    }

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

    $routes = $yaml->parse($yml_file);

    foreach($routes as $s_name => $s) {
      if(is_array($s)) {
      
        if(key_exists('pattern', $s) && 
           key_exists('controller', $s) && 
           key_exists('method', $s))
        {
          $this->router->set(
            $s_name,
            $s['pattern'], 
            $s['controller'], 
            $s['method']
          );
        }
        else if(key_exists('import', $s)) {
    
          if(is_string($s['import'])) {
            $this->load_from_yml(
              $s['import'],
              null, 
              (key_exists('prefix', $s) ? $s['prefix'] : "")
            );
          }
          else {
            $this->load_from_yml(
              $s['import']['file'],
              (key_exists('module', $s) ? $s['import']['module'] : null), 
              (key_exists('prefix', $s) ? $s['prefix'] : "")
            );
          }
          
        }
        else {
          ob_start();
          var_dump($s);
          $result = ob_get_clean();

          throw new PegaseException($result . " should contain the 'import', or 'module' and 'parameters' fields.");
        }
      }
      else
        throw new PegaseException($s . "should be an Array."); 
    }
    // end foreach
  }
}

