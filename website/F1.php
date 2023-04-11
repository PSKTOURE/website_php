<?php
/*
 * On indique que les chemins des fichiers qu'on inclut
 * seront relatifs au répertoire src.
 */
set_include_path("./src");

/* Inclusion des classes utilisées dans ce fichier */
require_once("Router.php");
require_once("view/View.php");
require_once("controller/Controller.php");
require_once("model/Discipline.php");
require_once("model/DisciplineStorageFile.php");
require_once("model/DisciplineStorageMySQL.php");
require_once("model/Discipline.php");
require_once("model/DisciplineBuilder.php");
require_once("../../../private/mysql_config.php");

/*
 * Cette page est simplement le point d'arrivée de l'internaute
 * sur notre site. On se contente de créer un routeur
 * et de lancer son main.
 */
$router = new Router();
$dsn = "mysql:host=". MYSQL_HOST . ";port=". MYSQL_PORT . ";dbname=" . MYSQL_DB . ";charset=" . MYSQL_CHARSET;
$user = MYSQL_USER;
$pass = MYSQL_PASSWORD;
$pdo = new PDO($dsn, $user, $pass);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$discplinesStorage = new DisciplineStorageMySQL($pdo);
$router->main($discplinesStorage);
