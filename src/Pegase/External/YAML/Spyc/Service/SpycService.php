<?php

namespace Pegase\External\YAML\Spyc\Service;

class SpycService {

  private $sm;

  public function __construct($sm, $params = array()) {
    $this->sm = $sm;
    //require_once(__DIR__ . '/../../../../../../vendor/mustangostang/spyc/Spyc.php');
    //géré par l'autoload ...
  }

  public function parse($file) {
    $path = $this->sm->get('pegase.core.path');

    return \Spyc::YAMLLoad($path->get_path($file));//__DIR__ . '/../../../../../../' . $file);
  }

  public function dump($array) {
    return \Spyc::YAMLDump($array);
  }
}

