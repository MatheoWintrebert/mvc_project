<?php
declare(strict_types=1);

require_once "$root/../vendor/autoload.php";
require_once "$root/models/Account.php";
require_once "$root/utils/Alert.php";

use Respect\Validation\Validator as v;

// Vérifie si le formulaire est soumis
if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $email = trim(string: $_POST["email"] ?? "");
  $password = trim(string: $_POST["password"] ?? "");
  $verifyPassword = trim(string: $_POST["verifyPassword"] ?? "");

  $emailValidator = v::email()->notEmpty();
  $passwordValidator = v::length(min: 8, max: null)->notEmpty();

  if (!$emailValidator->validate(input: $email)) {
    Alert::save(alert: new Alert(message: "L'email est invalide.", className: "danger"));
  } elseif (!$passwordValidator->validate(input: $password)) {
    Alert::save(alert: new Alert(message: "Le mot de passe doit contenir au moins 8 caractères.", className: "danger"));
  } elseif ($password !== $verifyPassword) {
    Alert::save(alert: new Alert(message: "Les champs concernant les mots de passe ne sont pas identiques.", className: "danger"));
  } elseif (Account::getAccountByEmail(email: $email)) {
    Alert::save(alert: new Alert(message: "Un compte existe déjà avec cet email.", className: "danger"));
  } else {
    $hashedPassword = password_hash(password: $password, algo: PASSWORD_DEFAULT);
      
    if (Account::createAccount(email: $email, password: $hashedPassword)) {
      Alert::save(alert: new Alert(message: "Votre compte a été créé.", className: "success"));
      header(header: "Location: ?action=login");
      exit;
    } else {
      Alert::save(alert: new Alert(message: "Erreur lors de la création du compte.", className: "danger"));
    }
  }
}

include_once "$root/views/register.php";
