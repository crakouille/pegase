<?php

namespace Pegase;

use Pegase\Core\Module\AbstractModule;

class PegaseModule extends AbstractModule {
  
  public function get_name() {
    return "Pegase";
  }

  public function get_path() {
    return __DIR__;
  }

  public function get_submodules() {
    return array(
      'Core'
    );
  }
}

