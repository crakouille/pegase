<?php

namespace Pegase\External\Template\Markdown;

use \Pegase\Core\Module\AbstractModule;
use \Pegase\External\Template\Markdown\Services\MarkdownService;

class MarkdownModule extends AbstractModule {

  public function get_name() {
    return "Template/Markdown";
  }
}

