<?php

namespace Pegase\Core\Shell\Command;


abstract class AbstractShellCommand {
  
  protected $sm;
  protected $shell;
  protected $output;
  protected $formater; // text formater

  const IS_OPTIONAL = 0; // 1 word at less
  const IS_REQUIRED = 1; // 1 param at less
  const IS_ARRAY = 2; // an array
  const IS_LINE = 4; // allows you to write a line directly (a path with ' ' by example)

  public function __construct($sm) {
    $this->sm = $sm;
    $this->shell = $sm->get('pegase.core.shell');
    $this->output = $this->shell->get_output();
    $this->formater = $this->output->get_text_formater();
  }
}

