<?php

namespace Pegase\Core;

use \Pegase\Core\Module\AbstractModule;

class CoreModule extends AbstractModule {
  
  public function get_name() {
    return "Core";
  }

  public function get_submodules() {
    return array(
      'Service',
      'Request',
      'Path', // nécessite Request
      'Router', // nécessite Path et Request
      'Exception',
      'Response',
      'Event'
    );
  }
}

