<?php

namespace Pegase\Core\Asset\Service;

use Pegase\Core\Service\Service\ServiceInterface;

class AssetService implements ServiceInterface {
  
  private $sm;
  private $ad; //assets_descriptors; // array de array(source_path, dest_path)
  
  public function __construct($sm, $params) {
    $this->sm = $sm;
    $this->ad = array();

    $yaml = $this->sm->get('pegase.component.yaml.spyc');
    $data = $yaml->parse('app/config/assets.yml');
    
    // vérifications à faire ... pas vraiment possible avec spyc
    
    $this->ad = $data;
  }

  public function get_assets_descriptors() {
    return $this->ad;
  }
}


