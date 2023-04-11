<?php
/**
 * Class representing a discipline
 * A discipline as a name, its category, the teams taking
 * part, the duration of the races, the name of actual champion
 * and a description of the juniors categories
 */
class Discipline
{

  private $name;
  private $category;
  private $teams;
  private $raceDuration;
  private $actualChampion;
  private $junior;

  //Constructor
  public function __construct($name, $category, $teams, $raceDuration, $actualChampion, $junior)
  {
    $this->name = $name;
    $this->category = $category;
    $this->teams = $teams;
    $this->raceDuration = $raceDuration;
    $this->actualChampion = $actualChampion;
    $this->junior = $junior;
  }
  // Getters
  /**
   * Getter
   * @return String name
   */
  public function getName()
  {
    return $this->name;
  }
  /**
   * Getter
   * @return String category
   */
  public function getCategory()
  {
    return $this->category;
  }
  /**
   * Getter
   * @return String teams
   */
  public function getTeams()
  {
    return $this->teams;
  }
  /**
   * Getter
   * @return int the duration of the race
   */
  public function getRaceDuration()
  {
    return $this->raceDuration;
  }
  /**
   * Getter
   * @return String the name of the actual champion
   */
  public function getChampions()
  {
    return $this->actualChampion;
  }
  /**
   * Getter
   * @return String the name of junior categories
   */
  public function getJunior()
  {
    return $this->junior;
  }
  /**
   * Setter
   * @param String name
   */
  public function setName($name)
  {
    $this->name = $name;
  }
  /**
   * Setter
   * @param String category
   */
  public function setCategory($category)
  {
    $this->category = $category;
  }
  /**
   * Setter
   * @param String teams
   */
  public function setTeams($teams)
  {
    $this->teams = $teams;
  }
  /**
   * Setter
   * @param int duration
   */
  public function setDuration($duration)
  {
    $this->raceDuration = $duration;
  }
  /**
   * Setter
   * @param String champion
   */
  public function setChampion($champion)
  {
    $this->actualChampion = $champion;
  }
  /**
   * Setter
   * @param String junior
   */
  public function setJunior($junior)
  {
    $this->junior = $junior;
  }
}
