<?php

class MainController
{
  private $actions;

  public function __construct()
  {
    $this->actions = [
      "login" => "LoginController.php",
      "profile" => "ProfileController.php",
      "register" => "registerController.php",
    ];
  }

  public function getControllerByAction(string $action): string
  {
    return array_key_exists(key: $action, array: $this->actions) ? $this->actions[$action] : "LoginController.php";
  }

  public function getActions(): array
  {
    return $this->actions;
  }
}
