<?php

namespace Pegase\Security\Form\Objects;

class FormView {
  
  private $type;
  private $inputs;
  private $input_table;

  public function __construct($target, $type, $inputs) {
    $this->target = $target;
    $this->type = $type;
    $this->inputs = $inputs;
  }

  public function start() {

    return "<form method=\"" . $this->type . "\" target=\"" . $this->target . "\">";
  }

  public function end() {
    return "</form>";
  }

  /*
        'var' => $input['var'] // the name
        'type_datas' => $this->input_table[$input['type']],
        'options' => $input['options']
  */

  public function input($var_name) { // closed tag
    $ret = '';

    foreach($this->inputs as $i => $input) {
      if($input['var'] == $var_name) {

        if($input['type_datas'][0] == 0) {
          $ret .= "<" . $input['type_datas'][1];
          
          if(count($input['type_datas']) > 2) {
            foreach($input['type_datas'][2] as $name => $content) {
              $ret .= " ${name}=\"${content}\"";
            }
          }

          $ret .= " />";
          unset($this->inputs[$i]); // on l'enlève
        }
        else
          echo "Mauvaise fonction: votre type de champs nécessite l'usage de `input_begin` et `input_end`";
      }
    }

    return $ret;
  }

  public function input_begin($var_name) {
    $ret = '';

    foreach($this->inputs as $i => $input) {
      if($input['var'] == $var_name) {

        if($input['type_datas'][0] == 1) {
          $ret .= "<" . $input['type_datas'][1];
          
          if(count($input['type_datas']) > 2) {
            foreach($input['type_datas'][2] as $name => $content) {
              $ret .= " ${name}=\"${content}\"";
            }
          }

          $ret .= ">";
          break; // on ne récupère que le premier
        }
        else
          echo "Mauvaise fonction: votre type de champs nécessite l'usage de `input`";
      }
    }

    return $ret;
  }

  public function input_end($var_name) {
    $ret = '';

    foreach($this->inputs as $i => $input) {
      if($input['var'] == $var_name) {

        if($input['type_datas'][0] == 1) {
          $ret .= "</" . $input['type_datas'][1];

          $ret .= ">";

          unset($this->inputs[$i]); // on l'enlève
          break; // on enlève que le premier
        }
        else
          echo "Mauvaise fonction: votre type de champs nécessite l'usage de `input`";
      }
    }

    return $ret;
  }

  public function generate($value = '') {

    $form = $this->start();

    $var_names = array();
    $has_close_tags = array();

    $form .= "\n";

    foreach($this->inputs as $input) {
      $var_names[] = $input['var'];
      $has_close_tags[$input['var']] = $input['type_datas'][0];
    }

    $var_names = array_unique($var_names);
    
    foreach($var_names as $var) {
      $form .= '  ';

      if($has_close_tags[$var] == 0) {
        $form .= $this->input($var);
      }
      else {
        $form .= $this->input_begin($var);
        $form .= $value;
        $form .= $this->input_end($var);
      }
 
      $form .= "\n";
    }

    $form .= $this->end();

    return $form;
  }
}
