<?php

namespace Pegase\Core\Shell\Command;
/*
function phrases_that_begin_with($debut) {
  return array(
    $debut . 'test'
  );
}

function your_callback($input, $index) {
  // Get info about the current buffer
  $rl_info = readline_info();
 
  // Figure out what the entire input is
  $full_input = substr($rl_info['line_buffer'], 0, $rl_info['end']);

  $matches = array();
 
  // Get all matches based on the entire input buffer
  foreach (phrases_that_begin_with($full_input) as $phrase) {
    // Only add the end of the input (where this word begins)
    // to the matches array
    $matches[] = substr($phrase, $index);
  }

  $matches = array('test', 'truc');
 
  return $matches;
}*/

class ShellCommands extends AbstractShellCommand {
  
  public function command_list() {
    
    $formater = $this->formater;

    $commands_names = array();
    $commands = $this->shell->get_commands();
  
    foreach($commands as $c) {
      $commands_names[] = $formater->set_color($c['name'], 'magenta');
    }

    //$this->sm->get_services_names();

    $max_len = 0;

    $this->output
      ->write_line(
        $formater->set_color(
          'Command list (' . count($commands) . ') :',
          'green'
        )
      )
      ->set_offset(2)
      ->write_lines($commands_names);

    /*readline_completion_function('Pegase\Core\Shell\Command\your_callback');
    $test = readline();
    echo "J'ai lu '", $test, "'\n";*/
  }

  public function help() {
        
    $this->shell->get_output()->write_line('================ Help ================');

    $this->command_list();
  }

  public function search($command) {
    
    $formater = $this->formater;

    $commands_names = array();
    $commands = $this->shell->get_commands();
  
    // pour chaque commande, on l'ajoute que si le début du nom
    // correspond avec le paramètre

    foreach($commands as $c) {
    
      if(preg_match('/^' . $command .'/', $c['name']) == 1) {
        $commands_names[] = $formater->set_color(
          $c['name'], 'magenta'
        );
      }
    }

    $this->output
      ->set_offset(2)
      ->write_lines_with_same_length($commands_names, 2);
  }

  public function search_parameters() {
    return array(
      array(
        'command', 
         AbstractShellCommand::IS_REQUIRED, 
         'What is the beginning of the command you are searching ?'
      )
    );
  } 

  public function search_options() {
    return array(
     /* array(
        '--test',
        AbstractShellCommand::REQUIRE_PARAM
      )*/
    );
  }
}

