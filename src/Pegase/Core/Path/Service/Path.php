<?php

namespace Pegase\Core\Path\Service;
use Pegase\Core\Service\Service\ServiceInterface;

class Path implements ServiceInterface {

  private $sm;
  private $root;
  
  public function __construct($sm, $params) {
    $this->sm = $sm;

    $this->root = $params['base_dir'];

    $len = strlen($this->root);
    
    if($len > 0 && $this->root[$len - 1] == "/")
      $this->root = substr($this->root, 0, $len - 1);
  }

  // dans les fonctions php
  public function get_root() { // point vers /
    return $this->root;
  }

  // relatif, pour les liens dans le html
  public function get_html_path($resource_path) { //pointe vers /web/$path

    $uri = $this->sm->get('pegase.core.request')->get_uri();
    $uri = explode('?', $uri);
    
    $uri = $uri[0];
    
    $nb = substr_count($uri, '/') - 1;

    $path = "";

    for($i = 0; $i < $nb; $i++) {
      $path .= "../";
    }

    $pos = strpos($resource_path, '/');
    
    if($pos === 0) {
      $resource_path = substr($resource_path, 1);
    }

    $path .= $resource_path;

    // si c'est le dossier principal, et qu'on est dans le dossier principal
    // on doit corriger le chemin
    if($path == '')
      $path = './';

    return $path;
  }

  public function get_path($path) {
    if($path[0] == '/')
      return $this->root . $path;
    else
      return $this->root . '/' . $path;
  }
}

