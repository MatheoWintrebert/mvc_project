<?php
declare(strict_types = 1);

/** @var string */
$root = dirname(path: __FILE__);

include_once "$root/controllers/MainController.php";

// $_REQUEST = $_POST OU $_GET (du moment que la variable est set dans l'un des 2 ça passe la condition)
/** @var string */
$action = isset($_REQUEST["action"]) ? $_REQUEST["action"] : "login";

$header = getHeaderByAction(action: $action);
$controller = getControllerByAction(action: $action);
$footer = getFooterByAction(action: $action);

$title = "Super Appli";
include_once "$root/views/header.php";
include_once "$root/controllers/".$controller;
include_once "$root/views/footer.php";
