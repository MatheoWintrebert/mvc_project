<?php
declare(strict_types=1);
require_once dirname(__DIR__, 2) . '/vendor/autoload.php';
/**
 * Récupère le controller associé à l'action donnée en paramètre
 * @param string $action
 * @return bool|int|string
 */
function getControllerByAction(string $action): string|int|bool
{
  /** @var array<string, string> $actions */
  $routes = [
    "login" => "LoginController.php",
    "register" => "RegisterController.php",
    "profile" => "ProfileController.php",
    "changePassword" => "ChangePasswordController.php",
    "game" => "GameController.php",
  ];
  // Définir si on redire sur 404, ou Home si connecté et Login si non-connecté
  return array_key_exists(key: $action, array: $routes) ? $routes[$action] : http_response_code(response_code: 404); // isLoggedOn() ? $routes["home"] : $routes["login"];
}

/**
 * Récupère l'header associé à l'action donnée en paramètre
 * @param string $action
 * @return string
 */
function getHeaderByAction(string $action): string
{
  return $action === "login" || $action === "register"
    ? "<header></header>"
    : '
    <header>
      <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
          <a class="navbar-brand" href="#">Navbar</a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
              <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="#">Home</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">Features</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">Pricing</a>
              </li>
              <li class="nav-item">
                <a class="nav-link disabled" aria-disabled="true">Disabled</a>
              </li>
            </ul>
          </div>
        </div>
      </nav>
    </header>
  ';
}

/**
 * Récupère le footer associé à l'action donnée en paramètre
 * @param string $action
 * @return string
 */
function getFooterByAction(string $action): string
{
  if ($action) {
  }
  return "<footer></footer>";
}
