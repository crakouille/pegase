<?php

namespace Pegase\Security\Form\Token;

use Pegase\Security\Form\Objects\FormView;

class TokenCSRF {
  
  private $target;
  private $id;
  //private $remote_addr; // les adresses autorisées, chaine ou liste

  public function __construct($target, $type = 'post') {
    $this->target = $target;
    $this->id = $type;
    $this->inputs = array();

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
      'button'   => array(1, 'button')
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
        target, -> the page we go
        var_name,
        $input_table[$input_type], -> contains default datas to set
        $input_options
      );
    */

    foreach($this->inputs as $input) {
      $inputs[] = array(
        'var' => $input['var'], // the name
        'type_datas' => $this->input_table[$input['type']],
        'options' => $input['options']
      );
    }

    return new FormView($this->target, $this->type, $inputs);
  }
}
