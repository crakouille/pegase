<?php

namespace Pegase\External\ORM\Doctrine2\Command;

use Pegase\Core\Shell\Command\AbstractShellCommand;

class Schema extends AbstractShellCommand {

  /*
    create_command:
    Generate and execute SQL code to create the database schema.
  */

  public function create_command($service_name) {

    // $doctrine represents the database configuration
    $doctrine = $this->sm->get($service_name);
    // schema represents manipulations over tables (alter, drop, create)
    $schema = $doctrine->get_schema();

    if(!$doctrine) {
      $this->shell->write_line('Service "' . $service_name . '" not found.');
      return;
    }
    
    $schema->create(); // we get the sql (array)

    $this->shell->offset = 2;

    $this->output->write_line(
      $this->formater->set_color(
        'Tables created', 'green'
      )
    );
  }

  public function create_command_parameters() {
    return array(
      array(
        'service', 
         AbstractShellCommand::IS_REQUIRED, 
         'Which doctrine service must be used ?'
      )
    );
  }

  /*
    create_dump_sql_command:
    Generate SQL code to create the database schema.
  */

  public function create_dump_sql_command($service_name) {

    // $doctrine represents the database configuration
    $doctrine = $this->sm->get($service_name);
    // schema represents manipulations over tables (alter, drop, create)
    $schema = $doctrine->get_schema();

    if(!$doctrine) {
      $this->output->write_line('Service "' . $service_name . '" not found.');
      return;
    }
    
    $sql = $schema->create_dump_sql(); // we get the sql (array)

    $this->shell->offset = 2;

    $this->output->write_lines($sql);
  }

  public function create_dump_sql_command_parameters() {
    return array(
      array(
        'service', 
         AbstractShellCommand::IS_REQUIRED, 
         'Which doctrine service must be used ?'
      )
    );
  }

  /*
    update_command:
    Generate SQL code to update the database schema.
  */

  public function update_command($service_name) {

    // $doctrine represents the database configuration
    $doctrine = $this->sm->get($service_name);
    // schema represents manipulations over tables (alter, drop, create)
    $schema = $doctrine->get_schema();

    if(!$doctrine) {
      $this->shell->write_line('Service "' . $service_name . '" not found.');
      return;
    }
    
    $schema->update(); // we get the sql (array)

    $this->output->write_line(
      $this->formater->set_color(
        'Update done',
        'green'
      )
    );
  }

  public function update_command_parameters() {
    return array(
      array(
        'service', 
         AbstractShellCommand::IS_REQUIRED, 
         'Which doctrine service must be used ?'
      )
    );
  }

  /*
    update_dump_sql_command:
    Generate SQL code to update the database schema.
  */

  public function update_dump_sql_command($service_name) {

    // $doctrine represents the database configuration
    $doctrine = $this->sm->get($service_name);
    // schema represents manipulations over tables (alter, drop, create)
    $schema = $doctrine->get_schema();

    if(!$doctrine) {
      $this->shell->write_line('Service "' . $service_name . '" not found.');
      return;
    }
    
    $sql = $schema->update_dump_sql(); // we get the sql (array)

    $this->output->write_lines($sql);
  }

  public function update_dump_sql_command_parameters() {
    return array(
      array(
        'service', 
         AbstractShellCommand::IS_REQUIRED, 
         'Which doctrine service must be used ?'
      )
    );
  }

  /*
    drop_command:
    Generate SQL code to drop the database schema.
  */

  public function drop_command($service_name) {

    // $doctrine represents the database configuration
    $doctrine = $this->sm->get($service_name);
    // schema represents manipulations over tables (alter, drop, create)
    $schema = $doctrine->get_schema();

    if(!$doctrine) {
      $this->shell->write_line('Service "' . $service_name . '" not found.');
      return;
    }
    
    $schema->drop(); // we get the sql (array)

    $this->output->write_line(
      $this->formater->set_color(
        'Database schema dropped',
        'green'
      )
    );
  }

  public function drop_command_parameters() {
    return array(
      array(
        'service', 
         AbstractShellCommand::IS_REQUIRED, 
         'Which doctrine service must be used ?'
      )
    );
  }

  /*
    drop_dump_sql_command:
    Generate SQL code to drop the database schema.
  */

  public function drop_dump_sql_command($service_name) {

    // $doctrine represents the database configuration
    $doctrine = $this->sm->get($service_name);
    // schema represents manipulations over tables (alter, drop, create)
    $schema = $doctrine->get_schema();

    if(!$doctrine) {
      $this->shell->write_line('Service "' . $service_name . '" not found.');
      return;
    }
    
    $sql = $schema->drop_dump_sql(); // we get the sql (array)

    $this->output->write_lines($sql);
  }

  public function drop_dump_sql_command_parameters() {
    return array(
      array(
        'service', 
         AbstractShellCommand::IS_REQUIRED, 
         'Which doctrine service must be used ?'
      )
    );
  }
}

