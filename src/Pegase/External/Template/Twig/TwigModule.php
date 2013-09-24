<?php

namespace Pegase\External\Template\Twig;

use \Pegase\Core\Module\AbstractModule;
use \Pegase\External\Template\Twig\Services\TwigService;

class TwigModule extends AbstractModule {
  
  public function get_name() {
    return "Template/Twig";
  }
}

