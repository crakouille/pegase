<?php

namespace Pegase\External\Template\Twig\Extensions;

interface FilterInterface {

  public function get_name();
  public function filter($param);

}

