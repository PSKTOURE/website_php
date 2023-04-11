<?php

/**
 * Class representing the view
 */
class View
{

  private $title;
  private $content;
  private $router;
  private $menu;
  private $feedback;
  private $source;

  /**
   * Constructor
   * @param Router $router: the view must have a reference to router in order have access to the urls
   * @param String $feedback
   */
  public function __construct(Router $router, $feedback)
  {
    $this->title = "";
    $this->content = "";
    $this->source = "";
    $this->feedback = $feedback;
    $this->router = $router;
    $this->setMenu();
  }

  /**
   * Method setting the menu of the page
   * The menu shows 3 different links
   */
  private function setMenu()
  {
    $arr = array(
      "HomePage" => $this->router->homePageURL(),
      "All" => $this->router->allDisciplinePageURL(),
      "Create" => $this->router->getDisciplineCreationURL(),
      "About" => $this->router->getAboutPageURL()
    );
    $this->menu = $arr;
  }

  /**
   * Method rendering the page
   * The page is seperated in 3 parts
   * A top containing the title, a middle(dynamiclly changing) and a bottom containing the differents links
   */
  public function render()
  {
    include "Top.php";
    echo $this->source;
    include "Bottom.php";
  }

  /**
   * Method for showing the corresponding page of a discipline
   */
  public function makeMotorSportPage($id, Discipline $discipline)
  {
    $this->title = "Page on " . $discipline->getName();
    $this->content = $discipline->getName() . " is in the " . $discipline->getCategory() . " category<br><br>The teams are:<br>";
    $arr = preg_split("/[,;_\-. ]/", $discipline->getTeams());
    $this->content .= "<ul>";
    for ($i = 0; $i < count($arr); $i++) {
      $this->content .= "<li>";
      $this->content .= $arr[$i];
      $this->content .= "</li>";
    }
    $this->content .= "</ul>";
    $this->content .= "The race duration is about " . $discipline->getRaceDuration() . " minutes long<br>";
    $this->content .= "The actual world champion is " . $discipline->getChampions() . "<br>";
    if ($discipline->getJunior() !== "") {
      $this->content .= "The junior categories are " . $discipline->getJunior();
    }
    ob_start();
    include("contentPage.php");
    $this->source = ob_get_clean();
  }

  /**
   * Method for showing the page listing all the 
   * disciplines stored in database
   */
  public function makeListPage($data)
  {
    $this->title = "Page containing the most famous motor racing categories!!!";
    $this->content = "The categories are:<br>";
    ob_start();
    include("ListView.php");
    $this->source = ob_get_clean();
  }

  /**
   * Method showing a unknow page when a action or id unknow is asked
   */
  public function makeUnknowPage()
  {
    echo "<h2>Unknow Page, sorry</h2>";
  }

  /**
   * Method showing the home page
   */
  public function homePage()
  {
    $this->source = "<h2>Home Page</h2><br>";
  }
  /**
   * Method showing a page for debugging
   */
  public function makeDebugPage($variable)
  {
    $this->title = 'Debug';
    $this->content = '<pre>' . htmlspecialchars(var_export($variable, true)) . '</pre>';
  }
  /**
   * Method showing the page containing the form for creating 
   * a new discpline or updating an existing one
   * Have an optional parameter $id for when the action is for updating
   */
  public function makeMotorSportCreationPage(DisciplineBuilder $builder, $id = null)
  {
    if ($id === null) {
      $this->title = "Create";
      $this->content = "Page for adding your prefered sport, enter valid input then submit";
      $url = $this->router->getDisciplineSaveURL();
    } else {
      $discipline = $this->getRouter()->getDisciplinesStorage()->read($id)->getName();
      $this->title = "Update Page for " . $discipline;
      $this->content = "Page for updating, enter valid input then submit.";
      $url = $this->router->getDisciplineSaveUpdateURL($id);
    }
    $error = $builder->getError();
    // La partie du formulaire
    ob_start();
    include("creation_update.php");
    $this->source = ob_get_clean();
  }

  /**
   * Method for the deletion page
   * Warns and asks if we want to delete corresponding object
   */
  public function makeDeletionPage($id)
  {
    $discipline = $this->getRouter()->getDisciplinesStorage()->read($id)->getName();
    $this->title = "Page for deleting " . $discipline . " From data base!!!";
    $this->content = "Are you sure you want to delete " . $discipline . "?!!<br>";
    $this->content .= "No comeBack after";
    // La partie du formulaire
    ob_start();
    include("DeletionPage.php");
    $this->source = ob_get_clean();
  }

  /**
   * Method showing the page confirming the deletion 
   */
  public function makeConfirmDeletionPage($id)
  {
    $discipline = $this->getRouter()->getDisciplinesStorage()->read($id)->getName();
    $this->title = "Deletion Confirmed";
    $this->source = $discipline . "have been successfully deleted.";
  }

  /**
   * Method redirecting the newly created object page with a positive feedback
   * when the creation was successfull
   */
  public function displayCreationSuccess($id)
  {
    $url = $this->router->getDisciplineURL($id);
    $this->router->POSTredirect($url, "CREATION SUCCESFULL");
  }

  /**
   * Method redirecting the updated object page with a positive feedback
   * when the update was successfull
   */
  public function displayUpdateSuccess($id)
  {
    $url = $this->router->getDisciplineURL($id);
    $this->router->POSTredirect($url, "UPDATE SUCCESFULL");
  }

  /**
   * Method redirecting the creation page with a negative feedback
   * when the creation was not successfull
   */
  public function displayCreationFailure()
  {
    $url = $this->router->getDisciplineCreationURL();
    $this->router->POSTredirect($url, "CREATION FAILED");
  }

  /**
   * Method redirecting the creation/update page with a negative feedback
   * when the updates were not successfull
   */
  public function displayUpdateError($id)
  {
    $url = $this->router->getDisciplineUpdateURL($id);
    $this->router->POSTredirect($url, "UPDATE FAILED");
  }

  /**
   * Method redirecting to the deletion page whith negativ feedback when action
   * was not successfull
   */
  public function displayDeletionFailure($id)
  {
    $url = $this->router->getDisciplineDeletionURL($id);
    $this->router->POSTredirect($url, "Unenable to delete");
  }

  public function displayDeletionSucces($id)
  {
    $url = $this->router->allDisciplinePageURL();
    $this->router->POSTredirect($url, "DELETED");
  }

  /**
   * Method showing an error page when something unexpected happened
   */
  public function makeUnexpectedErrorPage(Exception $e)
  {
    echo "Unexpected Error";
    var_dump($e->getMessage());
  }

  /**
   * Method for showing the about page
   */
  public function makeAboutPage()
  {
    $this->title = "About Page";
    $this->source = "<strong>Nom: TOURE Papa Samba Khary</strong><br>";
    $this->source .= "<strong>N°Étudiant: 21410550</strong><br>";
    $this->source .= "<strong>Points réalisés:</strong><br>";
    $this->source .= "<ul>";
    $this->source .= "<li>Lister les object</li>";
    $this->source .= "<li>Création d'un object</li>";
    $this->source .= "<li>Modification d'un object</li>";
    $this->source .= "<li>Utilisation d'un builder pour la validation et la création d'un object</li>";
    $this->source .= "<li>Supression d'un object</li>";
    $this->source .= "<li>Redirection GET aprés creation/modification/suppresion réussite ou pas avec un message de feedback</li>";
    $this->source .= "<li>L'utilisation d'un base de donnée MySql</li>";
    $this->source .= "</ul>";
    $this->source .= "<strong>Optionels réalisés:</strong><br>";
    $this->source .= "<ul>";
    $this->source .= "<li>Buttons pour trié la liste alphabétiquement<br>";
    $this->source .= "N'étant pas trés sur de moi j'ai préféré faire le tri coté serveur,<br>";
    $this->source .= "en me disant que cette fonctionnalité ne changerait pas même si on venait à changer de type de base de donnée</li>";
    $this->source .= "<li>Je n'ai pas voulut faire le complement sur les url/pathInfo car trouvant que l'url certe devient plus jolie,<br>";
    $this->source .= "mais devient plus compliqué de s'y retrouvé, voir dans l'url la valeur de chaque paramètre rend les choses plus facile pour s'y retrouver</li>";
    $this->source .= "</ul>";
    $this->source .= "Pour la vue, j'ai voulut la séparer en trois parties:";
    $this->source .= "<ul>";
    $this->source .= "<li>Top: qui contient le haut de la page avec le titre et les liens vers les pages accueil/liste/crétaion/about</li>";
    $this->source .= "<li>Bottom: qui contient la partie inférieur de la page contenant les liens vers les différents objects</li>";
    $this->source .= "<li>Mid: qui change en fonction de l'action demander.</li>";
    $this->source .= "</ul>";
    $this->source .= "J'ai eut pas mal de difficultés à le faire, car je voulais faire appel à un bout de page à un moment précis,<br>";
    $this->source .= "La solution que j'ai appliqué au finale est moche et assez confuse mais sur le momment je n'avais pas trouvé d'autres alternatives...<br>";
    $this->source .= "Je stocke la partie du milieu dans une variable source que je ensuite fait un echo dans le render apres l'include du top ";
    $this->source .= "et avant l'include du bottom.<br>";
    $this->source .= "Si le design du site à l'air si basique c'est parce que je n'avais encore jamais fait du html ou du css avant cette année ayant commencé l'info en L2 ";
    $this->source .= "et je n'ai pas eut du temps à consacrer pour apprendre le css.";
  }

  /* Function escaping HTML special chars */
  public function htmlesc($str)
  {
    return htmlspecialchars(
      $str,
      ENT_QUOTES | ENT_SUBSTITUTE | ENT_HTML5,
      'UTF-8'
    );
  }

  // GETTERS
  public function getTitle()
  {
    return $this->title;
  }

  public function getContent()
  {
    return $this->content;
  }

  public function getRouter()
  {
    return $this->router;
  }

  public function getMenu()
  {
    return $this->menu;
  }
}
