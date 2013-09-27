<?php

namespace Pegase\Core\Module\Command;

use Pegase\Core\Shell\Command\AbstractShellCommand;

class ListCommand extends AbstractShellCommand {
  
  public function modules_list() {
    
    $formater = $this->formater;
    $mm = $this->sm->get('pegase.core.module_manager');

    $commands_names = array();
    $modules = $mm->get_modules();
  
    foreach($modules as $c) {
      $commands_names[] = $formater->set_color($c->get_real_name(), 'magenta');
    }

    //$this->sm->get_services_names();

    $max_len = 0;

    $this->output
      ->write_line(
        $formater->set_color(
          'Module list (' . count($modules) . ') :',
          'green'
        )
      )
      ->set_offset(2)
      ->write_lines($commands_names);
  }
}

