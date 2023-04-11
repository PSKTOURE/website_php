<?php

class Router
{

  private $disciplinesStorage;

  // Home page URL
  public function homePageURL()
  {
    return "F1.php";
  }
  // URL of the discipline of identifier $id
  public function getDisciplineURL($id)
  {
    return "F1.php?id=" . $id;
  }
  // URL for listing all disciplines
  public function allDisciplinePageURL()
  {
    return "F1.php?action=list";
  }
  // URL for ordering alphabetically all the disciplines
  public function getAlphabeticalOrderASCURL()
  {
    return "F1.php?action=alphabeticASC";
  }
  // URL for ordering alphabetically in reverse all the disciplines
  public function getAlphabeticalOrderDSCURL()
  {
    return "F1.php?action=alphabeticDSC";
  }
  // URL for ordering by race duration 
  public function getDurationOrderASCURL()
  {
    return "F1.php?action=durationASC";
  }
  // URL for ordering by race duration 
  public function getDurationOrderDSCURL()
  {
    return "F1.php?action=durationDSC";
  }
  // URL for creating a discipline
  public function getDisciplineCreationURL()
  {
    return "F1.php?action=new";
  }
  // URL for saving 
  public function getDisciplineSaveURL()
  {
    return "F1.php?action=saveNew";
  }
  // URL for updating a discipline
  public function getDisciplineUpdateURL($id)
  {
    return "F1.php?id=" . $id . "&action=update";
  }
  // URL for saving the update
  public function getDisciplineSaveUpdateURL($id)
  {
    return "F1.php?id=" . $id . "&&action=saveUpdate";
  }
  // URL for deleting a discipline, ask for confirmation
  public function getDisciplineDeletionURL($id)
  {
    return "F1.php?id=" . $id . "&&action=del";
  }
  // URL confirming the deletion
  public function getDisciplineConfirmDeletionURL($id)
  {
    return "F1.php?id=" . $id . "&&action=confirmDel";
  }
  // URL for the about page
  public function getAboutPageURL(){
    return "F1.php?action=about";
  }


  /**
   * Main Function
   */
  public function main(DisciplineStorage $disciplinesStorage)
  {
    session_start();
    // Retrive feedback 
    $feedback = array_key_exists("feedback", $_SESSION) ? $_SESSION["feedback"] : "";
    // Create View
    $view = new View($this, $feedback);
    unset($_SESSION["feedback"]);
    // Instantiate controller
    $this->disciplinesStorage = $disciplinesStorage;
    $controller = new Controller($view, $this->disciplinesStorage);
    // Retrieve URL values
    $id = array_key_exists("id", $_GET) ? $_GET["id"] : null;
    $action = array_key_exists("action", $_GET) ? $_GET["action"] : null;
    // Set default value for the url
    if ($action === null) {
      $action = ($id === null) ? "home" : "show";
    }
    // Switch cases
    try {
      switch ($action) {
        case "show":
          if ($id === null) {
            $view->makeUnknowPage();
          } else {
            $controller->showInformation($id);
          }
          break;

        case "new":
          $controller->newDiscipline();
          break;

        case "saveNew":
          $id = $controller->saveNewDiscipline($_POST);
          break;

        case "del":
          if ($id === null) {
            $view->makeUnknowPage();
          } else {
            $controller->deleteDiscipline($id);
          }
          break;

        case "confirmDel":
          if ($id === null) {
            $view->makeUnknowPage();
          } else {
            $controller->confirmDisciplineDeletion($id);
          }
          break;

        case "update":
          if ($id === null) {
            $view->makeUnknowPage();
          } else {
            $controller->updateDiscipline($id);
          }
          break;

        case "saveUpdate":
          if ($id === null) {
            $view->makeUnknowPage();
          } else {
            $controller->saveUpdate($id, $_POST);
          }
          break;

        case "list":
          $controller->showList();
          break;

        case "alphabeticASC":
          $controller->showAlphabeticalOrder(true);
          break;
        
        case "alphabeticDSC":
          $controller->showAlphabeticalOrder(false);
          break;  

        case "durationASC":
          $controller->showDurationOrder(true);
          break;
        
        case "durationDSC":
          $controller->showDurationOrder(false);
          break;

        case "home":
          $view->homePage();
          break;
        
        case "about":
          $view->makeAboutPage();
          break;

        default:
          // Show unknow page if the case does not exist
          $view->makeUnknowPage();
          break;
      }
    } catch (Exception $e) {
      // Redirect to an error page if something unexpected happened
      $view->makeUnexpectedErrorPage($e);
    }
    $view->render();
  }

  // Method for redirecting POST request to a GET request
  public function POSTredirect($url, $feedback)
  {
    $_SESSION["feedback"] = $feedback;
    header("Location: " . $url, true, 303);
    exit();
  }
  // Getter
  public function getDisciplinesStorage()
  {
    return $this->disciplinesStorage;
  }
}
