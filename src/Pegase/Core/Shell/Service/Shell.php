<?php

namespace Pegase\Core\Shell\Service;

//use Pegase\Core\Response\Object\Response;

use Pegase\Core\Service\Service\ServiceInterface;
use Pegase\Core\Shell\Command\AbstractShellCommand;
use Pegase\Core\Shell\Service\ShellOutput;

class Shell implements ServiceInterface {
  
  private $sm;

  private $argc;
  private $argv;

  private $output;
  
  private $commands;

  /*// couleurs de fond

  private $bg_color_list;
  private $text_color_list;

  private $bg_color;
  private $text_color;
 
  public $offset; // left offset*/

  public function __construct($sm, $params) {
    $this->sm = $sm;
    $this->argc = $params[0];
    $this->argv = $params[1];

    $this->output = new ShellOutput($sm);

    $this->commands = array();
   
    //$this->load_commands_configs();
    $this->load_command_config_file('/app/config/shell.yml', '');
  }

  /* 
    load_commands_configs:
    on charge la configuration des commandes
  */

  private function load_commands_configs() { 
  
    // chargement du service de YAML
    $yaml = $this->sm->get('pegase.component.yaml.spyc');    
    $data = $yaml->parse('/app/config/shell.yml');

    foreach($data as $command_name => $command) {
    
      if(!key_exists('parameters', $command))
        $command['parameters'] = null;

      if(!key_exists('options', $command))
        $command['options'] = null;

      $this->add_command(array(
        'name' => $command_name,
        'class' => $command['class'],
        'method' => $command['method'],
        'parameters' => $command['parameters'],
        'options' => $command['options']
      ));
    }
  }

  // prefix: prefix of each command in the file

  private function load_command_config_file($file, $prefix) { 
    $yaml = $this->sm->get('pegase.component.yaml.spyc');    
    $data = $yaml->parse($file);

    $mm = $this->sm->get('pegase.core.module_manager');

    foreach($data as $command_name => $command) {
    
      if(key_exists('class', $command) && key_exists('method', $command)) {

        if(!key_exists('parameters', $command))
          $command['parameters'] = null;

        if(!key_exists('options', $command))
          $command['options'] = null;

        $this->add_command(array(
          'name' => $prefix . $command_name,
          'class' => $command['class'],
          'method' => $command['method'],
          'parameters' => $command['parameters'],
          'options' => $command['options']
        ));
      }
      else if(key_exists('import', $command)) {
        $this->load_command_config_file(
          $mm->get_file($command['import']['module'], $command['import']['file']), 
          $prefix . $command_name);
      }
    }
  }

  public function add_command($command) { // $command: array
    $this->commands[$command['name']] = $command;
  }

  public function contains($command_name) {
    return key_exists($command_name, $this->commands);
  }

  public function execute($name, $entry_params) {
    //echo "execution de la commande " . $name . "\n";
    $config = $this->commands[$name];
    $command = new $config['class']($this->sm);
 
    $params = array();

    if($config['parameters'] != null) {
      $params_infos = call_user_func(array($command, $config['parameters']));
     // var_dump($params_infos);

      $nb = count($entry_params);
      $nb_total = count($params_infos);

      for($i = 0; ($i < $nb) && ($i < $nb_total); $i++) {
        $params[$params_infos[$i][0]] = $entry_params[$i];
      }

      if($i < $nb_total) { 
        for(; $i < $nb_total; $i++) {
          if($params_infos[$i][1] & AbstractShellCommand::IS_REQUIRED) {
            do {
              $this->output->write_line($params_infos[$i][2]);
              $input = readline();

              $input = trim($input);
            } while(strlen($input) == 0);

            if($params_infos[$i][1] & AbstractShellCommand::IS_LINE) {
              $params[$params_infos[$i][0]] = $input;
            }
            else {
              $list = explode(' ', $input); // liste de paramètres

              // si c'est une liste, on la lui envoie
              if($params_infos[$i][1] & AbstractShellCommand::IS_ARRAY)
                $params[$params_infos[$i][0]] = $list;
              else // sinon on lui passe le premier élément de la liste
                $params[$params_infos[$i][0]] = $list[0];
            }
          }
          else // il n'y a plus de paramètres requis
            break;
        }
      } 
    }

    if($config['options'] != null) {
      $options = call_user_func(array($command, $config['options']));
      //var_dump($options);
    }

    call_user_func_array(array($command, $config['method']), $params);
  }

  public function get_output() {
    return $this->output;
  }

  public function get_commands() {
    return $this->commands;
  }
}

