<?php
$root = dirname(path: __FILE__);

include_once "$root/controllers/MainController.php";

$action = "default";
// $_REQUEST = $_POST OU $_GET (du moment que la variable est set dans l'un des 2 ça passe la condition)
if (isset($_REQUEST['action'])) {
  $action = $_REQUEST['action'];
}

$MainController = new MainController();

include_once "$root/controllers/" . $MainController->getControllerByAction(action: $action);
