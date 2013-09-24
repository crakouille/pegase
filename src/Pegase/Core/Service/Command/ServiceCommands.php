<?php

namespace Pegase\Core\Service\Command;

use Pegase\Core\Shell\Command\AbstractShellCommand;

class ServiceCommands extends AbstractShellCommand {
  
  public function service_list() {
    
    $this->output->write_line(
      $this->formater->set_color(
        'Services list:',
        'blue'
      )
    );

    $this->output->set_offset(2);
    $services_names = $this->sm->get_services_names();

    $lines = array();

    foreach($services_names as $name) {
      $lines [] = $this->formater->set_color(
        $name, 'magenta'
      );
    }

    $this->output->write_lines($lines);
  }
}

