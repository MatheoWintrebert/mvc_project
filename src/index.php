<?php
declare(strict_types = 1);

/** @var string */
$root = dirname(__FILE__);

include_once "$root/controllers/MainController.php";

// $_REQUEST = $_POST OU $_GET (du moment que la variable est set dans l'un des 2 ça passe la condition)
/** @var string */
$action = (isset($_REQUEST["action"])) ? $_REQUEST["action"] : "login";

$header = getHeaderByAction($action);
$controller = getControllerByAction($action);
$footer = getFooterByAction($action);

include_once "$root/views/header.php";
include_once "$root/controllers/".$controller;
include_once "$root/views/footer.php";
