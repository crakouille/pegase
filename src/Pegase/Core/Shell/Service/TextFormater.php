<?php

namespace Pegase\Core\Shell\Service;

//use Pegase\Core\Response\Object\Response;

use Pegase\Core\Service\Service\ServiceInterface;
use Pegase\Core\Shell\Command\AbstractShellCommand;

class TextFormater {
  
  // couleurs de fond

  private $bg_color_list;
  private $font_color_list;

  private $current_line;

  public function __construct() {
 
    $this->bg_color = 0; // background color
    $this->ft_color = 0; // font       color

    $this->font_color_list = array(
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
    $this->current_line = '';
  }

  public function set_color($text, $font_color, $bg_color = null) {

    $text = $this->set_ft_color($text, $font_color);

    if($bg_color != null)
      $text = $this->set_bg_color($text, $bg_color);

    return $text;
  }

  public function set_ft_color($text, $font_color) {

    if(is_string($font_color))
      $font_color = $this->font_color_list[$font_color];
    else
      $font_color = $font_color;

    $text = ("\033[" . $font_color . "m" . $text);

    return $text;
  }

  public function set_bg_color($text, $bg_color) {
    if(is_string($bg_color))
      $bg_color = $this->bg_color_list[$bg_color];
    else
      ;

    $text = ("\033[" . $bg_color . "m" . $text);

    return $text;
  }

}

