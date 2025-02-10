<?php
declare(strict_types=1);

require_once "$root/../vendor/autoload.php";
require_once "$root/models/Account.php";
require_once "$root/utils/Alert.php";

use Respect\Validation\Validator as v;

// Vérifie si l'utilisateur est connecté
if (!isLoggedOn() || empty($_SESSION["email"])) {
  header(header: "Location: ?action=login");
  exit;
}

$account = Account::getAccountByEmail(email: $_SESSION["email"]);

if (!$account) {
  Alert::save(alert: new Alert(message: "Compte introuvable.", className: "danger"));
  header(header: "Location: ?action=login");
  exit;
}

// Traitement du formulaire
if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $currentPassword = trim(string: $_POST["current-password"] ?? "");
  $newPassword = trim(string: $_POST["new-password"] ?? "");
  $confirmNewPassword = trim(string: $_POST["conf-new-password"] ?? "");
  
  $passwordValidator = v::length(min: 8, max: null)->notEmpty();

  if (empty($currentPassword) || empty($newPassword) || empty($confirmNewPassword)) {
    Alert::save(alert: new Alert(message: "Veuillez remplir l'ensemble des champs.", className: "danger"));
  } elseif (!$passwordValidator->validate(input: $newPassword)) {
    Alert::save(alert: new Alert(message: "Le nouveau mot de passe doit contenir au moins 8 caractères.", className: "danger"));
  } elseif ($newPassword !== $confirmNewPassword) {
    Alert::save(alert: new Alert(message: "La confirmation du mot de passe ne correspond pas.", className: "danger"));
  } elseif (!password_verify(password: $currentPassword, hash: $account->getPassword())) {
    Alert::save(alert: new Alert(message: "Le mot de passe actuel est incorrect.", className: "danger"));
  } else {        
    $hashedPassword = password_hash(password: $newPassword, algo: PASSWORD_DEFAULT);
      
    if (!Account::updatePasswordByEmail(email: $account->getEmail(), hashedPassword: $hashedPassword)) {
      Alert::save(alert: new Alert(message: "Une erreur est survenue lors de la mise à jour du mot de passe.", className: "danger"));
    } else {
      Alert::save(alert: new Alert(message: "Votre mot de passe a été mis à jour avec succès.", className: "success"));
      header(header: "Location: ?action=login");
      exit;
    }
  }
}

include_once "$root/views/changePassword.php";
