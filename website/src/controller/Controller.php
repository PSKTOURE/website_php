<?php

/**
 * Class representing the controller
 */
class Controller
{

  private $view;
  private $disciplinesStorage;
  /**
   * Constructor
   * @param View $view
   * @param DisciplineStorage $disciplineStorage : the database
   */
  public function __construct(View $view, DisciplineStorage $disciplinesStorage)
  {
    $this->view = $view;
    $this->disciplinesStorage = $disciplinesStorage;
  }
  // Getters
  public function getView()
  {
    return $this->view;
  }

  public function getDisciplinesStorage()
  {
    return $this->disciplinesStorage;
  }
  /**
   * Function for preparing the view of a discipline
   * @param $id: the stored id of the discipline in database
   */
  public function showInformation($id)
  {
    // Retrieve the corresponding object if it exist in database
    if (array_key_exists($id, $this->disciplinesStorage->readAll())) {
      $discipline = $this->disciplinesStorage->read($id);
      // Order the view to make the page
      $this->view->makeMotorSportPage($id, $discipline);
    } else {
      // if unknow id orders the view the show an error page
      $this->view->makeUnknowPage();
    }
  }
  /**
   * Function for preparing the view as a list
   * of all disciplines
   */
  public function showList()
  {
    // Retrieves all stored disciplines
    $disciplines = $this->disciplinesStorage->readAll();
    // Order the view to show the page
    $this->view->makeListPage($disciplines);
  }

  // Function for showing the home page
  public function showHomePage()
  {
    $this->view->homePage();
  }

  /**
   * Function for preparing the view
   * for the creation of a discipline
   */
  public function newDiscipline()
  {
    // Show the form with saved values or with default values
    $builder = array_key_exists("current", $_SESSION) ? $_SESSION["current"] : new DisciplineBuilder(array());
    $this->view->makeMotorSportCreationPage($builder);
  }

  /**
   * Function for preparing the view when a 
   * new discipline is createed
   */
  public function saveNewDiscipline(array $data)
  {
    // Intantiate builder for data
    $builder = new DisciplineBuilder($data);
    // If the data is valid
    if ($builder->isValid($data)) {
      // Create new discipline
      $discipline = $builder->createDiscipline();
      // Store in database
      $id = $this->disciplinesStorage->create($discipline);
      // Order view to show creation succes page
      $this->view->displayCreationSuccess($id);
      //unset last saved data
      if (array_key_exists('current', $_SESSION)) unset($_SESSION['current']);
    } else {
      // save current tentative creation
      $_SESSION['current'] = $builder;
      // Orders view to bring back the creation form with a failure feedback
      $this->view->displayCreationFailure();
    }
  }

  /**
   * Function for preparing the view when
   * the action is for deleting
   */
  public function deleteDiscipline($id)
  {
    // If key does not exist, redirect to an error page
    if (!array_key_exists($id, $this->disciplinesStorage->readAll())) {
      return $this->view->makeUnknowPage();
    }
    // Prepare the view asking if we want to delete or not
    $this->view->makeDeletionPage($id);
  }

  /**
   * Prepare the view confirming the deletion
   */
  public function confirmDisciplineDeletion($id)
  {
    // Delete corresponding object from database
    $ok = $this->disciplinesStorage->delete($id);
    // if deletion was not successfull redirect a failure page with a feedback
    if (!$ok)
      return $this->view->displayDeletionFailure($id);
      // Shows view confirming deletion
    $this->view->displayDeletionSucces($id);
  }

  /**
   * Prepare the view when the action is for
   * updating
   */
  public function updateDiscipline($id)
  {
    // fetch corresponding object
    $discipline = $this->disciplinesStorage->read($id);
    // if object does not exist redirect to an unknow page
    if ($discipline === null)
      return $this->view->makeUnknowPage();
    // Retrieve current updates if it was the case else instantiate a new builder using the corresponding object  
    $builder = array_key_exists("currentUpdate" . $id, $_SESSION) ? $_SESSION["currentUpdate" . $id] : DisciplineBuilder::buildBuilder($discipline);
    // Prepare the view for updating(same view as creating)
    $this->view->makeMotorSportCreationPage($builder, $id);
  }

  /**
   * Function saving the updates
   */
  public function saveUpdate($id, $data)
  {
    // instantiation of a builder from data recieved
    $builder = new DisciplineBuilder($data);
    // Get corresponding object from db
    $discipline = $this->disciplinesStorage->read($id);
    // data validation
    if ($builder->isValid()) {
      // if valid then update object
      $builder->updateDiscipline($discipline);
      // update object in db
      $ok = $this->disciplinesStorage->update($id, $discipline);
      if (!$ok)
        throw new Exception("Id does not exist");
      // unset the current update from the session  
      if (array_key_exists("currentUpdate" . $id, $_SESSION)) unset($_SESSION["currentUpdate" . $id]);
      // Shows the view with a succes feedback
      return $this->view->displayUpdateSuccess($id);
    }
    // else save current builder in session
    $_SESSION["currentUpdate" . $id] = $builder;
    // Display view with update error feedback
    $this->view->DisplayUpdateError($id);
  }

  /**
   * Helper function sorting two objects by comparing their name
   * alphabeticly in reverse order  
   */
  public function compareDSC(Discipline $a, Discipline $b)
  {
    return strtolower($a->getName()) < strtolower($b->getName());
  }

  /**
   * Helper function sorting two objects by comparing their name
   * alphabeticly
   */
  public function compareASC(Discipline $a, Discipline $b)
  {
    return strtolower($b->getName()) < strtolower($a->getName());
  }

  /**
   * Method sorting the data in function of names
   * if ascending == true sort the list in ascending manner
   */
  public function showAlphabeticalOrder($ascending)
  {
    $data = $this->disciplinesStorage->readAll();
    if ($ascending)
      usort($data, array("Controller", "compareASC"));
    else {
      usort($data, array("Controller", "compareDSC"));
    }
    $this->view->makeListPage($data);
  }

  /**
   * Method sorting the data in function of duration
   * if ascending == true sort the list in ascending manner
   */
  public function showDurationOrder($ascending)
  {
    $data = $this->disciplinesStorage->readAll();
    if ($ascending)
      usort($data, function ($a, $b) {
        return $a->getRaceDuration() > $b->getRaceDuration();
      });
    else {
      usort($data, function ($a, $b) {
        return $a->getRaceDuration() < $b->getRaceDuration();
      });
    };
    $this->view->makeListPage($data);
  }
}
