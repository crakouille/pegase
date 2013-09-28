<?php

namespace Pegase\Core\Service;

use Pegase\Core\Exception\Objects\PegaseException;

class ServiceManager {
  
  private $services; // services chargés
  private $services_known; // services non chargés mais que l'on peut charger
  // à tout instant

  public function __construct() {
    $this->services = array();
    $this->services_known = array();
  }

  public function set($name, $service) {
    $this->services[$name] = $service;
  }

  public function get($name) {
  
    return array_key_exists($name, $this->services)
      ? $this->services[$name]  // soit il est instancié
      : $this->instanciate_service($name); // soit on l'instancie, si il est déclaré
  }

  public function get_services_names() {
    return array_keys($this->services);
  }

  public function get_services_known_names() {
    return array_keys($this->services_known);
  }

  public function set_service_known($name, $service_infos) {
    $this->services_known[$name] = $service_infos;
  }

  public function instanciate_service($name) {
    $service = null;

    if(key_exists($name, $this->services_known)) {
      $service = new $this->services_known[$name][0]($this, $this->services_known[$name][1]);
      $this->set($name, $service);
      
      unset($this->services_known[$name]);
    }
    else {
      throw new PegaseException("The service `" . $name . "` is unknown");
    }

    return $service;    
  }
}

