<?php
declare(strict_types=1);

require_once "$root/../vendor/autoload.php";
require_once "$root/models/Login.php";
require_once "$root/utils/Alert.php";

use Respect\Validation\Validator as v;

logout();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $email = trim($_POST["email"] ?? "");
  $password = trim($_POST["password"] ?? "");

  $emailValidator = v::email()->notEmpty();
  $passwordValidator = v::notEmpty();

  if (!$emailValidator->validate($email)) {
    Alert::save(new Alert("L'email est invalide.", "danger"));
  } elseif (!$passwordValidator->validate($password)) {
    Alert::save(new Alert("Le mot de passe ne peut pas être vide.", "danger"));
  } else {
    $loginResult = login($email, $password);

    if ($loginResult["success"]) {
      header("Location: ?action=profile");
      exit;
    } else {
      Alert::save(new Alert("Erreur de connexion.", "danger"));
    }
  }
}

include_once "$root/views/login.php";
