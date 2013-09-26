<?php

namespace Pegase;

use Pegase\Core\Module\AbstractModule;

class PegaseModule extends AbstractModule {
  
  public function get_name() {
    return "Pegase";
  }

  public function get_path() {
    // ne fonctionnera que si le module est bien installé dans le vendor/ du projet, 
    // et n'est pas censé fonctionner s'il est dans le /vendor d'autres projets
    //  
    //return "vendor/nativgames/pegase/src/Pegase";
    return __DIR__;
  }

  public function get_submodules() {
    return array(
      'Core',
      'External'
    );
  }
}

