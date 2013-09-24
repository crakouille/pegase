<?php

namespace Pegase\Core\Http\Response;

class FileResponse implements ResponseInterface {
  
  private $filename;
  private $code;

  public function __construct($filename) {
    $this->filename = $filename;
  }

  public function set_filename($filename) {
    $this->filename = $filename;

    return $this;
  }

  public function get_filename() {
    return $this->filename;
  }

  public function send() {
    header ("Content-type: application/force-download");
    header ("Content-disposition: filename=" . $this->filename);
 
    readFile($chemin . $fichier); 
  }
}

