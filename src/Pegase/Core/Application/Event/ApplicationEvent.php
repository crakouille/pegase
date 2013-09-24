<?php

namespace Pegase\Core\Application\Event;

use Pegase\Core\Event\Event\EventInterface;

class ApplicationEvent implements EventInterface {
  
  protected $event_name;

  public function __construct($event_name) {
    $this->event_name = $event_name;
  }

  public function get_event_name()
  {
    return $this->event_name;
  }

  public function get_content() {
    return $this->content;
  }
}

