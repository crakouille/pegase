<?php

namespace Pegase\Core\Application\Event;

use Pegase\Core\Event\Event\EventInterface;

class ExceptionEvent implements EventInterface {
  
  protected $event_name;
  protected $content;

  public function __construct($event_name, $content) {
    $this->event_name = $event_name;
    $this->content = $content;
  }

  public function get_event_name()
  {
    return $this->event_name;
  }

  public function get_content() {
    return $this->content;
  }
}

