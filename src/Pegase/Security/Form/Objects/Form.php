<?php

namespace Pegase\Security\Form\Objects;

/*
  Classe non terminée.
  Classe "FormBuilder" à coder.
*/

use Pegase\Security\Form\Objects\FormView;

class Form {
  
  private $target;
  public $token;
  private $type;
  private $inputs;
  private $input_table;
  private $values;
  private $validator;

  private $tokenCSRFContainer;

  public function __construct($target, $tokenCSRFContainer, $type = 'post') {
    $this->target = $target;
    $this->type = $type;
    $this->token = null;
    $this->inputs = array();
    $this->values = array();
    $this->validator = null;
    $this->tokenCSRFContainer = $tokenCSRFContainer;
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
      'submit'   => array(0, 'input', array('type' => 'submit')),
      'hidden' =>   array(0, 'input', array('type' => 'hidden'))
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
  
    // S'il n'y a pas de token, on en crée un

    if(null == $this->token) {
      $this->token = $this->tokenCSRFContainer->generate();
    }
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

      if(key_exists($input['var'], $this->values)) {
        $opts['value'] = $this->values[$input['var']];
        //echo "value: ", $opts['value'], "<br />";
      }
      else;

      $inputs[$input['var']] = array(
        'var' => $input['var'], // the name
        'type_datas' => $this->input_table[$input['type']],
        'options' => $opts
      );
    }

    
    $inputs['token'] = array(
      'var' => 'token', // csrf token
      'type_datas' => $this->input_table['hidden'],
      'options' => array_merge(
        $this->input_table['hidden'][2],
        array('value' => $this->token->get_id())
       )
    );

    return new FormView($this->target, $this->type, $inputs, $this->values);
  }

  public function set_validator($validator) {
    $this->validator = $validator;

    return $this;
  }

  public function is_valid() {

    //echo count($this->inputs), " ", count($this->values), " ";

    // bon nombre d'arguments (input de type submit à ne pas compter, d'où le -1)
    //if((count($this->inputs) - 1) != count($this->values))
    if((count($this->inputs)) != count($this->values)) // mais token csrf à compter
      return false;
    
    // vérifications sur les types à faire

    // vérification du token csrf

    if(!$this->token)
      return false; // pas de token

    if(!$this->token->is_valid()) {
      $this->token = $this->tokenCSRFContainer->generate();

      return false;
    }

    // vérification du form validator si défini
    if($this->validator != null) {
      if(!$this->validator->is_valid($this))
        return false;
    }

    $this->tokenCSRFContainer->remove($this->token);
    $this->token = null;

    return true;
  }

  public function read_post() {

    foreach($this->inputs as $input) {
      if(key_exists($input['var'], $_POST)) {
        $this->values[$input['var']] = $_POST[$input['var']];
      }
      else;
    }

    $this->token = $this->tokenCSRFContainer->get($_POST['token']);
  }
}
