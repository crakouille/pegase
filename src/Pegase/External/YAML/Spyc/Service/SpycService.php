<?php

namespace Pegase\External\YAML\Spyc\Service;

use Pegase\Core\Exception\Objects\PegaseException;

class SpycService {

  private $sm;

  public function __construct($sm, $params = array()) {
    $this->sm = $sm;
    //require_once(__DIR__ . '/../../../../../../vendor/mustangostang/spyc/Spyc.php');
    //géré par l'autoload ...
  }

  public function parse($file) {
    $path = $this->sm->get('pegase.core.path');
      
    $p = $path->get_path($file);

    if($file == null)
      throw new PegaseException("File is NULL ... it doesn't exists.");

    else if(!file_exists($p))
      throw new PegaseException("File " . $p . " doesn't exists.");
    else
      ;

    return \Spyc::YAMLLoad($path->get_path($file));
  }

  public function dump($array) {
    return \Spyc::YAMLDump($array);
  }
}

