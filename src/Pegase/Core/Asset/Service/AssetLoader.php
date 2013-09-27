<?php

namespace Pegase\Core\Asset\Service;
use Pegase\Core\Service\Service\ServiceInterface;

use Pegase\Core\Exception\Objects\PegaseException;

class AssetLoader implements ServiceInterface {
  
  private $sm;
  private $_as;

  public function __construct($sm, $params = array()) {
    $this->sm = $sm;
  }

  public function set_asset_service($as) {
    $this->_as = $as;
  }

  public function load_from_yml($yml_file, $module = null) {
    $yaml = $this->sm->get('pegase.component.yaml.spyc');
    $module_manager = $this->sm->get('pegase.core.module_manager');

    if($module != null) {
      $yml_file = $module_manager->get_file($module, $yml_file);
    }
    else
      ; 

    $assets = $yaml->parse($yml_file);

    foreach($assets as $a_name => $s) {
      if(is_array($s)) {

        if(!key_exists('dest_path', $s)) {
          ob_start();
          var_dump($s);
          $result = ob_get_clean();

          throw new PegaseException($result . " should contain the 'dest_path' field.");
        }

        if(key_exists('import', $s)) {
          $this->load_from_yml($s['import']['file'], $s['import']['module']);
        }
        else if(key_exists('module', $s) && key_exists('source_path', $s)) {
  
          $this->_as->add($a_name, array(
            'source_path' => $module_manager->get_file($s['module'], $s['source_path']), 
            'dest_path' => $s['dest_path']
          ));
        }
        else if(key_exists('source_path', $s)) {
  
          $this->_as->add($a_name, $s);

          echo $s['source_path'], "\n";
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

