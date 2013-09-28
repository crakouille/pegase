<?php

namespace Pegase\Security\Form\Objects;

/*
  Classe non terminée.
  Classe "FormBuilder" à coder.
*/

use Pegase\Security\Form\Objects\FormView;

class Form {
  
  private $target;
  private $type;
  private $inputs;
  private $input_table;
  private $values;
  private $validator;

  public function __construct($target, $type = 'post') {
    $this->target = $target;
    $this->type = $type;
    $this->inputs = array();
    $this->values = array();
    $this->validator = null;
    /* 
      input_table:
      'key' => array(has close tag, )
    */

    $this->input_table = array(
      'string'   => array(0, 'input', array('type' => 'text')),
      'text'     => array(1, 'textarea'),
      'datetime' => array(0, 'input', array('type' => 'datetime')),
      'file'     => array(0, 'input', array('type' => 'file')),
      'hidden'   => array(0, 'input', array('type' => 'hidden')),
      'radio'    => array(0, 'input', array('type' => 'radio')),
      'checkbox' => array(0, 'input', array('type' => 'checkbox')),
      'button'   => array(1, 'button'),
      'submit'   => array(0, 'input', array('type' => 'submit'))
    );

  }

  public function add($var_name, $type = 'string', $options = array()) {

    $this->inputs[] = array(
      'var'     => $var_name, 
      'type'    => $type, 
      'options' => $options);

    return $this;
  }

  public function generate() {
  
    $inputs = array();

    /*
      Explication:

      inputs[] = array(
        var_name,
        $input_table[$input_type], -> contains default datas to set
        $input_options
      );
    */

    foreach($this->inputs as $input) {

      if(count($this->input_table[$input['type']]) < 3) {
        $opts = $input['options'];
      }
      else {
        $opts = array_merge($input['options'], $this->input_table[$input['type']][2]);
      }

      $inputs[] = array(
        'var' => $input['var'], // the name
        'type_datas' => $this->input_table[$input['type']],
        'options' => $opts
      );
    }

    return new FormView($this->target, $this->type, $inputs);
  }

  public function set_validator($validator) {
    $this->validator = $validator;

    return $this;
  }

  public function isValid() {

    // bon nombre d'arguments (input de type submit à ne pas compter, d'où le -1)
    if((count($this->inputs) - 1) != count($this->values))
      return false;

    // vérifications sur les types à faire

    // vérification du token csrf

    // vérification du form validator si défini
    if($this->validator != null) {
      if(!$this->validator->isValid($this))
        return false;
    }

    return true;
  }

  public function read_session() { 

    foreach($this->inputs as $input) {
      if(key_exists($input['var'], $_SESSION)) {
        $this->values[$input['var']] = $_SESSION[$input['var']];
      }
    }
  }
}
