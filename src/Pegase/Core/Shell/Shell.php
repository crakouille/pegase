<?php

namespace Pegase\Core\Shell;

use Pegase\Core\Application\AbstractApplication;
use Pegase\Core\Exception\Objects\NGException;
//use Pegase\Core\Response\Object\Response;

class Shell extends AbstractApplication {
  

  public function __construct($params, $modules, $argc, $argv, $base_dir) {
    parent::__construct($params, $modules, $base_dir);
    $sm = $this->sm;

    $shell = new \Pegase\Core\Shell\Service\Shell($sm, array(
      $argc,
      $argv
    ));

    $sm->set('pegase.core.shell', $shell);
    //$shell->load_commands();

    $output = $shell->get_output();
    $formater = $output->get_text_formater();
    // les commandes ont besoin de $shell dans le conteneur
    // c'est pour cela que le service n'est pas crée et chargé en même temps

    $module_manager = $sm->get('pegase.core.module_manager');
//    $module_manager->load_commands($sm);

    // -------

    try {
      
      if($argc >= 2) {
        $commande = $argv[1];
        array_shift($argv); // on enlève le premier élément de argv
        array_shift($argv); // idem: on enlève le nom de la commande, 
        // ainsi, on ne laisse que les paramètres de la commande dans $argv

        if($shell->contains($commande))
          $shell->execute($commande, $argv);
        else {
          
          $output
            ->write_line(
              $formater->set_color(
                'The command ', 'blue'
              ) . $formater->set_color(
                $commande, 'red'
              ) . $formater->set_color(
                ' is not defined, maybe you wanna call one of these commands: ', 'blue'
              )
            );

          $shell->execute('shell:commands:search', array($commande));
        }
      }
      else {
        $shell->execute('shell:commands:help', array());
      }
        //throw new NGException("test");
    }
    catch (NGException $e) {
        $shell->set_color('green', 'red');
        echo "Caught NGException ('", 
             $e->getMessage(), 
             "'):\n",
             $e,
             "\n";
    }

    //$shell->get_output()->set_color(0)->end_line();
  }

  public function get_base_dir() { 
    return $this->base_dir;
  }
}

