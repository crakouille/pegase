<?php

namespace Pegase\External\ORM\Doctrine2\Service\DoctrineService;

use \Pegase\Core\Service\Service\ServiceInterface;

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

use Doctrine\DBAL\DriverManager;

class Database {

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
    Create the database for the doctrine service
  */

  public function create() {

    $params = $this->doctrine->get_db_params();
    $connection = DriverManager::getConnection($params);
    
    // 1) Test of the existence of the database

    try {
      $t = $connection->connect();
      $connection->close();
      return 1;
    }    
    catch(\Exception $e) {
    }

    // 2) creation of the database

    $dbname = $params['dbname'];
    
    unset($params['dbname']);

    $connection = DriverManager::getConnection($params);

    $schema = $connection->getSchemaManager();
    $params = $connection->getParams();

    try {
      $schema->createDatabase($dbname);
    }
    catch(\Exception $e) {
      return 2; //echo "Could not create database '". $dbname . "'\n";
    }

    $connection->close();

    return 0; // 0 si la db a été crée
  }
  
  /*
    drop:
    Generate SQL code and execute it to drop the database schema.
  */

  public function drop() {

    $params = $this->doctrine->get_db_params();
    $connection = DriverManager::getConnection($params);

    // 1) Test of the existence of the database

    try {
      $t = $connection->connect();
    }    
    catch(\Exception $e) {
      return 1;
    }

    $schema = $connection->getSchemaManager();

    // 2) drop the database

    try {
      $schema->dropDatabase($params['dbname']);
    }
    catch(\Exception $e) {
      $connection->close();
      return 2;//echo "Could not create database '". $params['dbname'] . "'\n";
    }

    $connection->close();
  
    return 0;
  }

}

