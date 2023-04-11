<?php

/**
 * Class for building a new Discipline from
 * from data sent by the client
 */
class DisciplineBuilder
{

  private $data;
  private $error;
  private const N_REF = "name";
  private const C_REF = "category";
  private const T_REF = "teams";
  private const D_REF = "duration";
  private const CH_REF = "champion";
  private const J_REF = "junior";
  /**
   * Constructor
   * Build new instance with default values
   * if data equal to null
   */
  public function __construct($data = null)
  {
    if ($data === null) {
      $data = array(
        self::N_REF => "",
        self::C_REF => "",
        self::T_REF => "",
        self::D_REF => "",
        self::CH_REF => "",
        self::J_REF => "",
      );
    }
    $this->data = $data;
    $this->error = array();
  }

  /**
   * Function for creating a new discipline
   * Throws an exception if data is uncomplete
   */
  public function createDiscipline()
  {
    if (
      !array_key_exists(self::N_REF, $this->data) || !array_key_exists(self::C_REF, $this->data) ||
      !array_key_exists(self::T_REF, $this->data) || !array_key_exists(self::D_REF, $this->data) ||
      !array_key_exists(self::CH_REF, $this->data) || !array_key_exists(self::J_REF, $this->data)
    ) {
      throw new Exception("Missing fields");
    }
    return new Discipline(
      $this->data[self::N_REF],
      $this->data[self::C_REF],
      $this->data[self::T_REF],
      $this->data[self::D_REF],
      $this->data[self::CH_REF],
      $this->data[self::J_REF]
    );
  }

  /**
   * Function for validating if the string is
   * less than 150 characters,
   * non empty
   * and contains only alphanumeric characters
   */
  public function isStringValid($str, $ok=false)
  {
    // ok = Some fields are allowed to be empty
    if($ok)
      return mb_strlen($str, 'UTF-8') < 150 && preg_match("/(\w+|)/", $str);
    return mb_strlen($str, 'UTF-8') < 150 && $str !== "" && preg_match("/[\w+]/", $str);
  }
  /**
   * Function for validating the duration
   * The duration must be greater than zero 
   */
  public function isDurationValid()
  {
    if (!key_exists(self::D_REF, $this->data) || !($this->data[self::D_REF] > 0))
      //Add error message to error array
      $this->error[self::D_REF] = "You must enter a positive number";
  }
  /**
   * Function for validating 
   * all the recieved data
   */
  public function isValid()
  {
    $this->isKeyValid(self::N_REF);
    $this->isKeyValid(self::C_REF);
    $this->isKeyValid(self::T_REF);
    $this->isKeyValid(self::CH_REF);
    $this->isKeyValid(self::J_REF, true);
    $this->isDurationValid();
    return count($this->error) === 0;
  }
  /**
   * Function validating if the key exist
   * and if its value is valid
   */
  public function isKeyValid($key, $ok=false)
  {
    if (!key_exists($key, $this->data) || !self::isStringValid($this->data[$key], $ok))
      $this->error[$key] = "You must enter a valid input for the " . $key;
  }
  /**
   * Function for updating a discipline
   * Set the values of fields to corresponding
   * values recieved in $data
   * @param $discpline: the discipline to be updated
   * @return void
   */
  public function updateDiscipline(Discipline $discipline)
  {
    if (array_key_exists(self::N_REF, $this->data))
      $discipline->setName($this->data[self::N_REF]);

    if (array_key_exists(self::C_REF, $this->data))
      $discipline->setCategory($this->data[self::C_REF]);

    if (array_key_exists(self::T_REF, $this->data))
      $discipline->setTeams($this->data[self::T_REF]);

    if (array_key_exists(self::D_REF, $this->data))
      $discipline->setDuration($this->data[self::D_REF]);

    if (array_key_exists(self::CH_REF, $this->data))
      $discipline->setChampion($this->data[self::CH_REF]);

    if (array_key_exists(self::J_REF, $this->data))
      $discipline->setJunior($this->data[self::J_REF]);
  }

  /**
   * Function returning a new instance of disciplineBuilder
   * created from the data of the discipline passed as paramter
   * @param Discipline $discipline
   * @return DisciplineBuilder builder
   */
  public static function buildBuilder(Discipline $discipline)
  {
    return new DisciplineBuilder(array(
      self::N_REF => $discipline->getName(),
      self::C_REF => $discipline->getCategory(),
      self::T_REF => $discipline->getTeams(),
      self::D_REF => $discipline->getRaceDuration(),
      self::CH_REF => $discipline->getChampions(),
      self::J_REF => $discipline->getJunior(),
    ));
  }
  /**
   * Function returning the value of a key if
   * it exist in data
   * @param $key : the key
   * @return value if key exist else empty string
   */
  public function getValue($key)
  {
    return key_exists($key, $this->data) ? $this->data[$key] : '';
  }
  /**
   * Getter
   * @return array $data
   */
  public function getData()
  {
    return $this->data;
  }
  /**
   * @return array $error
   */
  public function getError()
  {
    return $this->error;
  }

  // GETTERS to constants
  public function getNameRef()
  {
    return self::N_REF;
  }

  public function getCatRef()
  {
    return self::C_REF;
  }

  public function getTeamsRef()
  {
    return self::T_REF;
  }

  public function getDRef()
  {
    return self::D_REF;
  }

  public function getChampRef()
  {
    return self::CH_REF;
  }

  public function getJuniorRef()
  {
    return self::J_REF;
  }
}
