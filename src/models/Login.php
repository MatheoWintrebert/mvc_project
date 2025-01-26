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
  $account = Account::getAccountByEmail($email);
  $emailAccount = $account["email"];
  $passwordAccount = $account["password"];

  if (session_start() && $emailAccount === $email && password_verify($password, $passwordAccount)) {
    $_SESSION["email"] = $account["email"];
    $_SESSION["password"] = $account["password"];
  }

  var_dump($_SESSION);

  return ["success" => isset($_SESSION["email"]) && isset($_SESSION["password"]), "email" => $_SESSION["email"] ?? null, "password" => $_SESSION["password"] ?? null];
}

/**
 * Permet de déconnecter l'utilisateur
 * @return void
 */
function logout(): void {
  if (!isset($_SESSION)) {
    session_start();
  }
  unset($_SESSION["email"]);
  unset($_SESSION["password"]);
}

/**
 * Détermine si le user est connecté
 * @return bool
 */
function isLoggedOn(): bool {
  if(!isset($_SESSION)) {
    session_start();
  }
  
  if (empty($_SESSION["email"]) || empty($_SESSION["password"])) {
    return false;
  }

  $account = Account::getAccountByEmail($_SESSION["email"]);
  // return $account && $account["email"] === $_SESSION["email"] && $account["password"] === $_SESSION["password"];


  return empty($_SESSION["email"]) || empty($_SESSION["password"]) ? 
  false : 
    Account::getAccountByEmail($_SESSION["email"])["email"] === $_SESSION["email"] &&
    Account::getAccountByEmail($_SESSION["email"])["password"] === $_SESSION["password"];
}
