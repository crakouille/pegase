<?php

namespace Pegase\Core\Shell;

use \Pegase\Core\Module\AbstractModule;

class ShellModule extends AbstractModule {
  
  public function get_name() {
    return "Shell";
  }

  public function get_base_name() {
    return "Pegase/Core/";
  }

  public function get_path() {
    //return "vendor/nativgames/Pegase/Core/Shell";
    return __DIR__;
  }
}

