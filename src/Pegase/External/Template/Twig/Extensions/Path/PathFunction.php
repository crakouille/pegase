<?php

namespace Pegase\External\Template\Twig\Extensions\Path;
use \Pegase\External\Template\Twig\Extensions\FunctionInterface;

class PathFunction implements FunctionInterface {

  private $sm;

  public function __construct($sm) {
    $this->sm = $sm;
  }

  public function get_name() {
    return 'path';
  }

  public function fn($param) {
    $path_s = $this->sm->get('pegase.core.path');
    
    return $path_s->get_html_path($param);
  }

}

