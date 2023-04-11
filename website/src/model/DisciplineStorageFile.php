<?php
require_once "lib/ObjectFileDB.php";
require_once "DisciplineStorage.php";
/*
 * Class represnting the database
 * Information are stocked in a file for simplicity reason
 * Implements DisciplineStorage
 */

class DisciplineStorageFile implements DisciplineStorage
{

  private ObjectFileDB $db;
  // Constructor
  public function __construct($file)
  {
    $this->db = new ObjectFileDB($file);
  }

  /**
   * Function for restoring the database
   * to its default state
   */
  public function reinit()
  {
    // Delete everything before rebuilding
    $this->db->deleteAll();
    $f3 = new Discipline("Formula3", "open_wheel_single_seater", "Prema, ART, Carlin, Trident", 30, "Victor_Martins", "");
    $f2 = new Discipline("Formula2", "open_wheel_single_seater", "Prema, ART, Dams, MP_Motorsport", 45, "Piastri", "f3");
    $f1 = new Discipline("Formula1", "open_wheel_single_seater", "Mercedes, RedBull, Ferrari, Mcalaren", 90, "Verstappen", "f2, f3");
    $wec = new Discipline("World_Endurance_Championship", "endurance_racing", "Toyota, Peugeot, Porsche, Corvette", 360, "N°7", "");
    $moto2 = new Discipline("Moto2", "motor_bike_racing", "American_racing, RedBull_ktm", 40, "Remy Gardner", "");
    $motoGp = new Discipline("MotoGp", "motor_bike_racing", "Honda, Yamaha, Ducatti", 45, "Quartararo", "moto2");
    $disciplines = array("f1" => $f1, "f2" => $f2, "f3" => $f3, "wec" => $wec, "moto2" => $moto2, "motoGp" => $motoGp);
    foreach ($disciplines as $key => $val) {
      $this->db->insert($val);
    }
  }
  /**
   * Getter
   * Return the database
   */
  public function getDB()
  {
    return $this->db;
  }
  /**
   * Function returning an saved object
   * @param $id : the identifier 
   * @return the corresponding object
   */
  public function read($id)
  {
    return $this->db->fetch($id);
  }
  /**
   * Function fetching all the stored objects
   */
  public function readAll()
  {
    return $this->db->fetchAll();
  }
  /**
   * Function for saving a new discipline into
   * the database
   * @param $discipline: the new object to be saved
   * @return void
   */
  public function create(Discipline $discipline)
  {
    return $this->db->insert($discipline);
  }
  /**
   * Function for deleting an object from database
   * @param $id: the identifier of the discipline to be deleted
   * @return void
   */
  public function delete($id)
  {
    if ($this->db->exists($id)) {
      $this->db->delete($id);
      return true;
    }
    return false;
  }
  /**
   * Function for updating a discpline
   * @param $id: the id of the discipline to be updated
   * @param $obj: reference to discipline to be updated
   * @return void
   */
  public function update($id, $obj)
  {
    if ($this->db->exists($id)) {
      $this->db->update($id, $obj);
      return true;
    }
    return false;
  }
}
