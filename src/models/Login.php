<?php
declare(strict_types=1);

include_once "$root/utils/json.php";
include_once "$root/models/Account.php";

/**
 * Permet de login l'utilisateur
 * @param string $email
 * @param string $password
 * @return array{success: bool, email: null|string, password: null|string}
 */
function login(string $email, string $password): array {
  if (session_status() === PHP_SESSION_NONE) {
    session_start();
  }

  $account = Account::getAccountByEmail($email);

  if ($account && password_verify($password, $account->getPassword())) {
    $_SESSION["email"] = $account->getEmail();
    
    return [
      "success" => true,
      "email" => $_SESSION["email"]
    ];
  }

  return [
    "success" => false,
    "email" => null
  ];
}

/**
 * Permet de déconnecter l'utilisateur
 * @return void
 */
function logout(): void {
  if (session_status() === PHP_SESSION_NONE) {
    session_start();
  }
  unset($_SESSION["email"]);
}

/**
 * Détermine si l'utilisateur est connecté
 * @return bool
 */
function isLoggedOn(): bool {
  if (session_status() === PHP_SESSION_NONE) {
      session_start();
  }

  if (empty($_SESSION["email"])) {
      return false;
  }

  $account = Account::getAccountByEmail($_SESSION["email"]);
  
  return !empty($account) && $account->getEmail() === $_SESSION["email"];
}
