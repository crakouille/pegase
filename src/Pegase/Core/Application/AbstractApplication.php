<?php

namespace Pegase\Core\Application;

use Pegase\Core\Response\Object\Response;
use Pegase\Core\Exception\Objects\NGException;
use Pegase\Core\Module\ModuleManager;
use Pegase\Core\Service\ServiceManager;

use Pegase\External\YAML\Spyc\Service\SpycService;
use Pegase\Core\Service\Service\ServiceLoader;
use Pegase\Core\Path\Service\Path;

abstract class AbstractApplication {
  
  protected $params;
  protected $sm; // service manager

  public function __construct($params, $modules, $base_dir) {
    $this->params = $params;

    $sm = new ServiceManager();
    $this->sm = $sm;
    
    $module_manager = new ModuleManager($sm, $modules);
    
    // Chargement des services de base    
    $sm->set('pegase.core.path', new Path($sm, array('base_dir' => $base_dir)));
    $sm->set('pegase.core.module_manager', $module_manager);
    $sm->set('pegase.component.yaml.spyc', new SpycService($sm));
    $sm->set('pegase.core.service_loader', new ServiceLoader($sm));
    
    // We load each submodule in order to get the structure of the projet,
    // and to load commands for instant.
    $module_manager->load_submodules($sm);

    // Chargement de la configuration des services
    // Les Services ne sont pas instanciés ! Cela ne se produit qu'au premier appel
    // de $sm->get('nom_service')
    $service_loader = $this->sm->get('pegase.core.service_loader');
    $service_loader->load_from_yml('app/config/services.yml');

    // récupérer l'event manager charge tous les event listeners
    $event_manager = $this->sm->get('pegase.core.event_manager');
    // L'application est enfin chargée

    $a = $module_manager->get_modules();
    /*echo "<pre>";
    foreach($a as $t) {
      echo $t->get_real_path(), " ", $t->get_real_name(), "\n";
    }
    echo "</pre>";*/
  }

  public function get_base_dir() { 
    return $this->base_dir;  
  }
}

