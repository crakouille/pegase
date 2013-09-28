<?php

namespace Pegase\Core\Service\Command;

use Pegase\Core\Shell\Command\AbstractShellCommand;

class ServiceCommands extends AbstractShellCommand {
  
  public function service_list() {
    
    $this->output->write_line(
      $this->formater->set_color(
        'Services list:',
        'green'
      )
    );

    $lines = array();

    // services instanciés
    $lines[] = $this->formater->set_color(
      "Services instancied:", 'blue'
    );
      
    $this->output->set_offset(2);
    $this->output->write_lines($lines);
    $lines = array();

    $services_names = $this->sm->get_services_names();

    foreach($services_names as $name) {
      $lines[] = $this->formater->set_color(
        $name, 'magenta'
      );
    }

    $this->output->set_offset(4);
    $this->output->write_lines($lines);
    $lines = array();

    // services connus
    $lines[] = $this->formater->set_color(
      "Services known and not instancied:", 'blue'
    );

    $this->output->set_offset(2);
    $this->output->write_lines($lines);
    $lines = array();

    $services_names = $this->sm->get_services_known_names();

    foreach($services_names as $name) {
      $lines[] = $this->formater->set_color(
        $name, 'magenta'
      );
    }

    $this->output->set_offset(4);
    $this->output->write_lines($lines);
  }
}

