<?php

namespace Pegase\Core\Asset\Service;

use Pegase\Core\Service\Service\ServiceInterface;
use Pegase\Core\Exception\Objects\PegaseException;
use Pegase\Core\Asset\Loader\AssetLoader;

class AssetService implements ServiceInterface {
  
  private $sm;
  private $ad; //assets_descriptors; // array de array(source_path, dest_path)
  private $loader;
  
  public function __construct($sm, $params) {
    $this->sm = $sm;
    $this->ad = array();


    $this->loader = new AssetLoader($sm);
    $this->loader->set_service($this);

    $this->loader->load_from_yml('app/config/assets.yml');
  }

  public function add($asset_name, $asset_descriptor)
  {
    $this->ad[$asset_name] = $asset_descriptor;
  }

  public function get_assets_descriptors() {
    return $this->ad;
  }
}


