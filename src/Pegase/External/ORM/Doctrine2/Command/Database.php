<?php

namespace Pegase\External\ORM\Doctrine2\Command;

use Pegase\Core\Shell\Command\AbstractShellCommand;

class Database extends AbstractShellCommand {

  /*
    create:
    Generate and execute SQL code to create the database schema.
  */

  public function create_command($service_name) {

    // $doctrine represents the database configuration
    $doctrine = $this->sm->get($service_name);
    // schema represents manipulations over tables (alter, drop, create)
    $database = $doctrine->get_database();

    if(!$doctrine) {
      $this->output->write_line('Service "' . $service_name . '" not found.');
      return;
    }

    $ret = $database->create();
    
    $dbname = $doctrine->get_db_params()['dbname'];

    if($ret == 0) { // we get the sql (array)

      $this->output->write_line($this->formater->set_color(
            'Database ', 'green'
          ) . $this->formater->set_color(
            $dbname, 'blue'
          ) . $this->formater->set_color(
            ' created', 'green'
        ));
    }
    else {

      if($ret == 1) {
        $this->output->write_line($this->formater->set_color(
            'Database ', 'red'
          ) . $this->formater->set_color(
            $dbname, 'blue'
          ) . $this->formater->set_color(
           ' already exists', 'red'
        ));

      }
      else { // 2

        $this->output->write_line($this->formater->set_color(
            'Could not create database ', 'red'
          ) . $this->formater->set_color(
            $dbname, 'blue'
        ));
      }
    }
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
    drop_command:
    Generate SQL code to drop the database schema.
  */

  public function drop_command($service_name) {

    // $doctrine represents the database configuration
    $doctrine = $this->sm->get($service_name);
    // schema represents manipulations over tables (alter, drop, create)
    $database = $doctrine->get_database();

    if(!$doctrine) {
      $this->shell->write_line('Service "' . $service_name . '" not found.');
      return;
    }
    
    $ret = $database->drop(); // we get the sql (array)

    if($ret == 0) { // we get the sql (array)

      //$this->shell->set_color('green');

      $dbname = $doctrine->get_db_params()['dbname'];

      $this->output->write_line($this->formater->set_color(
          'Database ', 'green'
        ) . $this->formater->set_color(
          $dbname, 'blue'
        ) . $this->formater->set_color(
          ' dropped', 'green'
      ));
    }
    else {
      $this->shell->set_color('red');

      $dbname = $doctrine->get_db_params()['dbname'];

      if($ret == 1) {
        $this->output->write_line($this->formater->set_color(
            'Database ', 'green'
          ) . $this->formater->set_color(
            $dbname, 'blue'
          ) . $this->formater->set_color(
            ' doesn\'t exists.', 'green'
        ));
      }
      else {// 2
        $this->shell->write_line(' "'. $dbname . '"');
        $this->output->write_line($this->formater->set_color(
            'Could not drop database ', 'green'
          ) . $this->formater->set_color(
            $dbname, 'blue'
        ));
      }
    }
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

}

