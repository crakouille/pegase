<?php

namespace Pegase\Core\Event\Listener;
use Pegase\Core\Service\Services\ServiceInterface;

interface EventListenerInterface {

  public function __construct($sm, $params);
}

