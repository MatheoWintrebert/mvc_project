<?php
class MainController {
  /** @property-read array<string, string> $actions */
  private readonly array $actions;

  /**
  * Instancie un MainController.
  *
  * Permet de set l'attribut actions avec un tableau associatif [string action => string Controller.php]
  *
  * @return void Ne return rien.
  */
  public function __construct() {
    $this->actions = [
      "login" => "LoginController.php",
      "profile" => "ProfileController.php",
      "changePassword" => "ChangePasswordController.php", 
    ];
  }

  /**
  * Renvoie le controller correspondant à l'action si l'action est correcte, page 404 sinon.
  *
  * Prend un string en argument.
  *
  * @param string $action L'action réclamée par l'utilisateur.
  * @return string|int|bool Le controller associé à cette action si existant, page 404 sinon (peut-être à changer).
  */
  public function getControllerByAction(string $action): string {
    // Définir si on redire sur 404, ou Home si connecté et Login si non-connecté
    return array_key_exists($action, $this->actions) ? $this->actions[$action] : http_response_code(404); // isLoggedOn() ? $this->actions["home"] : $this->action["login"];
  }

  /**
  * Renvoie le header en fonction de l'action.
  *
  * Prend un string en argument.
  *
  * @param string $action L'action réclamée par l'utilisateur.
  * @return string L'header de la page.
  */
  public function getHeaderByAction(string $action): string {
    return $action === "login"
      ? "<header></header>"
      : '
      <header>
        <nav class="navbar navbar-expand-lg bg-body-tertiary">
          <div class="container-fluid">
            <a class="navbar-brand" href="#">Navbar</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
              <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                  <a class="nav-link active" aria-current="page" href="#">Home</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="#">Link</a>
                </li>
                <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                  Dropdown
                </a>
                <ul class="dropdown-menu">
                  <li><a class="dropdown-item" href="#">Action</a></li>
                  <li><a class="dropdown-item" href="#">Another action</a></li>
                  <li><hr class="dropdown-divider"></li>
                  <li><a class="dropdown-item" href="#">Something else here</a></li>
                </ul>
              </li>
              <li class="nav-item">
                <a class="nav-link disabled" aria-disabled="true">Disabled</a>
              </li>
            </ul>
            <form class="d-flex" role="search">
              <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
              <button class="btn btn-outline-success" type="submit">Search</button>
            </form>
          </div>
        </div>
      </nav>
    </header>
    ';
  }

  public function getFooterByAction(string $action): string {
    return "<footer></footer>";
  }
}