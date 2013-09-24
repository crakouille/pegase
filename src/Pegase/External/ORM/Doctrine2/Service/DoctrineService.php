<?php

namespace Pegase\External\ORM\Doctrine2\Service;

use Pegase\Core\Service\Service\ServiceInterface;

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
//use Doctrine\ORM\Tools\SchemaValidator;

use Pegase\External\ORM\Doctrine2\Service\DoctrineService\Schema;
use Pegase\External\ORM\Doctrine2\Service\DoctrineService\Database;
use Pegase\External\ORM\Doctrine2\Service\DoctrineService\Entity;

class DoctrineService implements ServiceInterface {

  private $sm;
  private $em;//$entity_manager;

  private $schema;
  private $database;
  private $entity;

  private $db_params;

  public function __construct($sm, $params = array()) {
    $this->sm = $sm;
    $path = $sm->get('pegase.core.path');

    foreach($params['entities_folders'] as $i => $f) {
        $params['entities_folders'][$i] = $path->get_path($f);
    }

    $this->db_params = $params['database'];

    $isDevMode = true;
    $config = Setup::createAnnotationMetadataConfiguration($params['entities_folders'], $isDevMode);

    $this->em = EntityManager::create($params['database'], $config);

  /*
    // on vérifie la validité des mappings

    $validator = new SchemaValidator($this->em);
    $errors = $validator->validateMapping();

    if(count($errors) > 0) {
      // Lots of errors!
      echo implode("\n\n", $errors);
    }
    else
      echo "Les mappings sont ok.\n";
  */

    $this->schema = new Schema($sm, $this);
    $this->database = new Database($sm, $this);
    $this->entity = new Entity($sm, $this);
  }

  public function get_doctrine_entity_manager() {
    return $this->em;
  }

  public function get_schema() {
    return $this->schema;
  }

  public function get_database() {
    return $this->database;
  }

  public function get_entity() {
    return $this->entity;
  }

  public function get_db_params() {
    return $this->db_params;
  }

}

