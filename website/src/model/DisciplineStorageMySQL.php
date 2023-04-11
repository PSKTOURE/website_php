<?php

/**
 * Class representing the database
 * Data is stored in a MySQL database
 * Implements DisciplineStorage
 */
class DisciplineStorageMySQL implements DisciplineStorage
{ 
  // Instance of PDO for accessing the SGBD
  private $pdo;

  // Constructor
  function __construct($pdo)
  {
    $this->pdo = $pdo;
  }

  /**
   * Function representing the query for 
   * fetching an object from database
   * Uses prepared query for security reason
   * @param $id : the identifier 
   * @return Discipline the corresponding object
   */
  public function read($id)
  {
    // Write query with placeholders
    $query = "SELECT * FROM disciplines WHERE id=:id";
    // Prepare query
    $statement = $this->pdo->prepare($query);
    $data = array(":id" => $id);
    // Execute query
    $statement->execute($data);
    // Stored returned result
    $fetchedData = $statement->fetch();
    // Instantiate a new builder from data fetched
    $builder = new DisciplineBuilder($fetchedData);
    // Create corresponding discipline
    $discipline = $builder->createDiscipline();
    return $discipline;
  }

   /**
   * Function representing the query for 
   * fetching all objects from database
   * Uses prepared query for security reason
   * @return array containing all the objects
   */
  public function readAll()
  {
    // the result array to return
    $result = array();
    // prepare query
    $query = "SELECT * FROM disciplines";
    $statement = $this->pdo->query($query);
    // fetch associative array containing all the data
    $data = $statement->fetchAll();
    // loop through data to create each discipline
    foreach ($data as $key => $val) {
      $id = $val["id"];
      $builder = new DisciplineBuilder($val);
      $discipline = $builder->createDiscipline();
      $result[$id] = $discipline;
    }
    return $result;
  }


   /**
   * Function representing the query for 
   * inserting an object in database
   * Uses prepared query for security reason
   * @return int the last inserted id
   */
  public function create(Discipline $discipline)
  {
    $query = "INSERT INTO `disciplines` (name, category, teams, duration, champion, junior) VALUES (:name, :category, :teams, :duration, :champion, :junior)";
    $statement = $this->pdo->prepare($query);
    $data = array(
      ":name" => $discipline->getName(),
      ":category" => $discipline->getCategory(),
      ":teams" => $discipline->getTeams(),
      ":duration" => $discipline->getRaceDuration(),
      ":champion" => $discipline->getChampions(),
      ":junior" => $discipline->getJunior()
    );
    $statement->execute($data);
    return $this->pdo->lastInsertId();
  }

   /**
   * Function representing the query for 
   * deleting an object from database
   * Uses prepared query for security reason
   * @return true if operation was succesfull, else false
   */
  public function delete($id)
  {
    if (!array_key_exists($id, $this->readAll()))
      return false;
    $query = "DELETE FROM `disciplines` WHERE id=:id";
    $statement = $this->pdo->prepare($query);
    $data = array(":id" => $id);
    $statement->execute($data);
    return true;
  }

   /**
   * Function representing the query for 
   * updating an object from database
   * Uses prepared query for security reason
   * @return true if operation was succesfull, else false
   */
  public function update($id, $discipline)
  {
    if (!array_key_exists($id, $this->readAll()))
      return false;
    $query = "UPDATE `disciplines` SET name=:name, category=:category, teams=:teams, duration=:duration, champion=:champion, junior=:junior WHERE id=:id";
    $statement = $this->pdo->prepare($query);
    $data = array(
      ":name" => $discipline->getName(),
      ":category" => $discipline->getCategory(),
      ":teams" => $discipline->getTeams(),
      ":duration" => $discipline->getRaceDuration(),
      ":champion" => $discipline->getChampions(),
      ":junior" => $discipline->getJunior(),
      ":id" => $id,
    );
    $statement->execute($data);
    return true;
  }
}
