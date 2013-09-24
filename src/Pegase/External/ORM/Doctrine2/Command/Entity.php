<?php

namespace Pegase\External\ORM\Doctrine2\Command;

use Pegase\Core\Shell\Command\AbstractShellCommand;

class Entity extends AbstractShellCommand {

  public function entity_list_command($service_name) {
    // $doctrine represents the database configuration
    $doctrine = $this->sm->get($service_name);

    if(!$doctrine) {
      $this->output->write_line('Service "' . $service_name . '" not found.');
      return;
    }

    // On affiche la liste des entités
    $em = $doctrine->get_doctrine_entity_manager();
    $driver = $em->getConfiguration()->getMetadataDriverImpl();
    $entities_names = $driver->getAllClassNames();

    $lines = array();

    foreach($entities_names as $n) {
      $lines[] = $this->formater->set_color(
        '  ' . $n, 'green', 'blue'
      );
    }

    $this->output
      //->set_offset(2)
      ->write_lines_with_same_length($lines, 2);
  }

  public function entity_list_command_parameters() {
    return array(
      array(
        'service', 
         AbstractShellCommand::IS_REQUIRED, 
         'Which doctrine service must be used ?'
      )
    );
  }

  /*

  */

  public function create_command($service_name, $path) {
    // $doctrine represents the database configuration
    $doctrine = $this->sm->get($service_name);

    if(!$doctrine) {
      $this->output->write_line('Service "' . $service_name . '" not found.');
      return;
    }

    $entity = $doctrine->get_entity();
    
    $params = array();
    $file = $entity->create($path, $params);

    $this->output
      //->set_offset(2)
      ->write_line($file, 2);
  }

  public function create_command_parameters() {
    return array(
      array(
        'service', 
         AbstractShellCommand::IS_REQUIRED, 
         'Which doctrine service must be used ?'
      ),
      array(
        'path', 
         AbstractShellCommand::IS_REQUIRED, 
         'Write the path you want the entity to be written:'
      )
    );
  }

}

