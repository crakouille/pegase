<?php

namespace Pegase\External\ORM\Doctrine2\Service\DoctrineService;

use \Pegase\Core\Service\Service\ServiceInterface;

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

class Schema {

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
    Generate SQL code and execute it.
  */

  public function create() {
    $driver = $this->em->getConfiguration()->getMetadataDriverImpl();
    $entities_names = $driver->getAllClassNames();

    $entities_metadata = array();

    foreach($entities_names as $name) {
      array_push(
        $entities_metadata, 
        $this->em->getClassMetadata($name)
      );
    }

    $tool = new \Doctrine\ORM\Tools\SchemaTool($this->em);

    $tool->createSchema($entities_metadata);
  }

  /*
    create_dump_sql:
    Generate SQL code and execute it.
  */

  public function create_dump_sql() {
    $driver = $this->em->getConfiguration()->getMetadataDriverImpl();
    $entities_names = $driver->getAllClassNames();

    $entities_metadata = array();

    foreach($entities_names as $name) {
      array_push(
        $entities_metadata, 
        $this->em->getClassMetadata($name)
      );
    }

    $tool = new \Doctrine\ORM\Tools\SchemaTool($this->em);

    return $tool->getCreateSchemaSql($entities_metadata);
  }

  /*
    update:
    Generate SQL code and execute it to update the database schema.
  */

  public function update() {
    $driver = $this->em->getConfiguration()->getMetadataDriverImpl();
    $entities_names = $driver->getAllClassNames();

    $entities_metadata = array();

    foreach($entities_names as $name) {
      array_push(
        $entities_metadata, 
        $this->em->getClassMetadata($name)
      );
    }

    $tool = new \Doctrine\ORM\Tools\SchemaTool($this->em);

    $tool->updateSchema($entities_metadata);
  }

  /*
    update_dump_sql:
    Generate SQL code to update the database schema.
  */

  public function update_dump_sql() {
    $driver = $this->em->getConfiguration()->getMetadataDriverImpl();
    $entities_names = $driver->getAllClassNames();

    $entities_metadata = array();

    foreach($entities_names as $name) {
      array_push(
        $entities_metadata, 
        $this->em->getClassMetadata($name)
      );
    }

    $tool = new \Doctrine\ORM\Tools\SchemaTool($this->em);

    return $tool->getUpdateSchemaSql($entities_metadata);
  }

  /*
    drop:
    Generate SQL code and execute it to drop the database schema.
  */

  public function drop() {
    $driver = $this->em->getConfiguration()->getMetadataDriverImpl();
    $entities_names = $driver->getAllClassNames();

    $entities_metadata = array();

    foreach($entities_names as $name) {
      array_push(
        $entities_metadata, 
        $this->em->getClassMetadata($name)
      );
    }

    $tool = new \Doctrine\ORM\Tools\SchemaTool($this->em);

    $tool->DropSchema($entities_metadata);
  }

  /*
    drop_dump_sql:
    Generate SQL code to drop the database schema.
  */

  public function drop_dump_sql() {
    $driver = $this->em->getConfiguration()->getMetadataDriverImpl();
    $entities_names = $driver->getAllClassNames();

    $entities_metadata = array();

    foreach($entities_names as $name) {
      array_push(
        $entities_metadata, 
        $this->em->getClassMetadata($name)
      );
    }

    $tool = new \Doctrine\ORM\Tools\SchemaTool($this->em);

    return $tool->getDropSchemaSql($entities_metadata);
  }
}

