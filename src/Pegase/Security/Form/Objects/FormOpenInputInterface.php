<?php

namespace Pegase\Security\Form\Objects;

interface FormOpenInputInterface {

  // render the <tag> with flags
  public function render_begin();

  // render the </tag>
  public function render_end();
}


