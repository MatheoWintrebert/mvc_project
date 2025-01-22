<?php
declare(strict_types=1);

/** @var string */
$root = dirname(__FILE__);

include_once "$root/controllers/MainController.php";

/** @var string */
$action = "login";
// $_REQUEST = $_POST OU $_GET (du moment que la variable est set dans l'un des 2 ça passe la condition)
if (isset($_REQUEST["action"])) {
  $action = $_REQUEST["action"];
}

/** @var MainController */
$MainController = new MainController();

$header = $MainController->getHeaderByAction($action);
$controller = $MainController->getControllerByAction($action);
$footer = $MainController->getFooterByAction($action);

include_once "$root/views/header.php";
include_once "$root/controllers/".$controller;
include_once "$root/views/footer.php";
