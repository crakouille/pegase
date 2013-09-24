<?php

namespace Pegase\Core\Shell\Service;

//use Pegase\Core\Response\Object\Response;

use Pegase\Core\Service\Service\ServiceInterface;
use Pegase\Core\Shell\Command\AbstractShellCommand;

use Pegase\Core\Shell\Service\TextFormater;

class ShellOutput {
  
  // couleurs de fond

  private $bg_color_list;
  private $text_color_list;

  private $bg_color;
  private $text_color;
 
  private $offset; // left offset

  private $text_formater;

  public function __construct($sm) {
 
    $this->bg_color = 0;
    $this->text_color = 0;

    $this->text_color_list = array(
      'black'    => 30,
      'red'      => 31,
      'green'    => 32,
      'yellow'   => 33,
      'blue'     => 34,
      'magenta'  => 35,
      'cyan'     => 36,
      'white'    => 37,
    );

    $this->bg_color_list = array(
      'black'    => 40,
      'red'      => 41,
      'green'    => 42,
      'yellow'   => 43,
      'blue'     => 44,
      'magenta'  => 45,
      'cyan'     => 46,
      'white'    => 47,
    );

    $this->offset = 0;
    //$this->current_line = '';

    $this->text_formater = new TextFormater();
  }

  /*public function set_color($text_color, $bg_color = null, $register = 1) {

    if(is_string($text_color))
      $color = $this->text_color_list[$text_color];
    else
      $color = $text_color;

    if($register == 1)
      $this->text_color = $text_color;

    $this->current_line .= ("\033[" . $color . "m");

    if($bg_color != null)
      $this->set_bg_color($bg_color, $register);

    return $this;
  }

  public function set_bg_color($color, $register = 1) {
    if(is_string($color))
      $color = $this->bg_color_list[$color];
    else
      ;

    if($register == 1)
      $this->bg_color = $color;

    $this->current_line .= ("\033[" . $color . "m");

    return $this;
  }*/

  private function write($text) {

    echo $text;
  }

  private function end_line() {

    //echo $this->current_line;
    //$this->current_line = '';

    echo $this->text_formater->set_color('', 0);
    echo "\n";

    return $this;
  }

  public function write_line($text) {

    for($i = 0; $i < $this->offset; $i++)
      echo ' ';

    $this->write($text);

    $this->end_line();

    return $this;
  }

  public function write_lines($lines) {

    foreach($lines as $l) {
      $this->write_line($l);
    }

    return $this;
  }

  public function write_lines_with_same_length($lines, $right_offset) {

    $max_len = 0;

    foreach($lines as $l) {
      $len = strlen($l);

      if($max_len < $len)
        $max_len = $len;
    }

    $max_len += $right_offset;

    foreach($lines as $l) {
      
      for($len = strlen($l); $len < $max_len; $len ++)
        $l .= ' ';

      $this->write_line($l);
    }

    return $this;
  }

  public function set_offset($offset) {
    $this->offset = $offset;
  
    return $this;
  }

  public function get_offset() {
    return $this->offset;
  }

  public function get_text_formater() {
    return $this->text_formater;
  }
}

