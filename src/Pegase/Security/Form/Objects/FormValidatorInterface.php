<?php

namespace Pegase\Security\Form\Objects;

use Pegase\Security\Form\Objects\FormView;

interface FormValidator {  
  public function is_valid($form);
}

