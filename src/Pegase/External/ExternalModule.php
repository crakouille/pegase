<?php

namespace Pegase\External;

use \Pegase\Core\Module\AbstractModule;

class ExternalModule extends AbstractModule {
  
  public function get_name() {
    return "External";
  }

  public function get_submodules() {
    return array(
      'Template/Twig',
      'YAML/Spyc',
      'ORM/Doctrine2'
    );
  }
}

