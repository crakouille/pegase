<?php

namespace Pegase\Core\Asset\Command;

use Pegase\Core\Shell\Command\AbstractShellCommand;

class AssetCommands extends AbstractShellCommand {
  
  public function asset_list_command() {

    $output = $this->output;
    $formater = $this->formater;

    // 1) on récupère les éléments à afficher

    $asset_service = $this->sm->get('pegase.core.asset');
    $assets_list = $asset_service->get_assets_descriptors();

    $lines = array();

    foreach($assets_list as $a) {
      $lines[] = $formater->set_color(
        $a['source_path'] . " => " . $a['dest_path'],
        'magenta'
      );
    }

    // 2) affichage

    $output
      ->write_line(
      $formater->set_color('Assets list:', 'blue')
    )
     ->set_offset(2)
     ->write_lines_with_same_length($lines, 2);
  }

  public function asset_install_command() {
    
    $output = $this->output;
    $formater = $this->formater;

    $path = $this->sm->get('pegase.core.path');

    $output
      ->write_line(
        $formater->set_color(
          'Assets installation:', 'blue'
        )
      )
      ->set_offset(2);

    /*$this->shell->set_color('blue');
    $this->shell->write_line('Assets list:');
    $this->shell->set_color('green');
    
    $this->shell->offset = 2;
    */

    $asset_service = $this->sm->get('pegase.core.asset');
    $assets_list = $asset_service->get_assets_descriptors();

    $lines = array();

    foreach($assets_list as $a) {
      if(file_exists($path->get_path($a['source_path']))) {
        //echo $a['source_path'] , " exists\n";
      }
      else
        ;//echo $a['source_path'], " doesn't exists\n";

      if(file_exists($path->get_path($a['dest_path'])) ||
         is_link($path->get_path($a['dest_path']))
      ) {
        unlink($path->get_path($a['dest_path']));
        //echo "il faut supprimer\n";
      }
      else; // echo $path->get_path($a['dest_path']), " not found\n";
      
      if(!file_exists($path->get_path(dirname($a['dest_path'])))) {
        mkdir($path->get_path(dirname($a['dest_path'])), 0777, true);
      }

      if(@symlink($path->get_path($a['source_path']), 
          $path->get_path($a['dest_path'])) == true)

        $output->write_line(
          "Symlink " . $a['source_path'] . " => " . 
          $a['dest_path'] . " created.");

      else 
        $output->write_line(
          "Symlink " . $a['source_path'] . " => " . 
          $a['dest_path'] . " not created.");

      //$lines[] = $a['source_path'] . " => " . $a['dest_path'];
    }

    //$this->shell->write_lines_with_same_length($lines, 2);
  }
}

