<?php

namespace Pegase\External\Template\Markdown\Services;

use \Pegase\Core\Service\Service\ServiceInterface;
use \Michelf\Markdown;

class MarkdownService implements ServiceInterface {

  private $sm;
  private $loader;
  private $twig;

  public function __construct($sm, $params = array()) {

    $this->sm = $sm;
  }

  public function parse($txt) {
    return Markdown::defaultTransform($txt);
  }
}

