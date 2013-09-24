<?php

namespace Pegase\Security\Form\Objects\Input; 

use Pegase\Security\Form\Objects\FormClosedInputInterface;

class SubmitButton implements FormClosedInputInterface {

  public function render() {
    return "<input value=\"Soumettre\" type=\"submit\" />";
  }
}


