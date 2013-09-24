<?php

namespace Pegase\External\ORM\Doctrine2\Service\DoctrineService;

use \Pegase\Core\Service\Service\ServiceInterface;

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

class Entity {

  private $sm;
  private $doctrine;

  private $em;//$entity_manager;

  public function __construct($sm, $doctrine) {
    $this->sm = $sm;
    $this->doctrine = $doctrine;

    $this->em = $doctrine->get_doctrine_entity_manager();
  }

  /*
    create:
    Create an entity file
  */

  public function create($entity_path, array $params) {

    $exploded = explode('/', $entity_path);

    $nb = count($exploded);

    $namespace = $exploded[1];

    for($i = 2; $i < ($nb - 1); $i++) {
      $namespace .= '\\' . $exploded[$i];
    }

    $namespace = str_replace('.php', '', $namespace);

    $class = explode('/', $entity_path);
    $class = $namespace; //$class[count($class) - 1];

    $file =
"namespace ${namespace};

class ${class} {

  private \$id;
}
";

    return $file;
  }
 
}

