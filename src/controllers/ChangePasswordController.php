<?php
include_once "$root/models/Account.php";

if (isLoggedOn()) {
  $account = Account::getAccountByEmail($_SESSION["email"]);

  $alert = "";
  if ($_SERVER["REQUEST_METHOD"] === "POST") {  
    if (
      empty($_POST["current-password"]) ||
      empty($_POST["new-password"]) ||
      empty($_POST["conf-new-password"])
    ) {
      $alert = "Veuillez remplir l'ensemble des champs";
    }   
    elseif (strlen(string: $_POST["new-password"]) < 8) {
      $alert = "Le nouveau mot de passe doit faire plus de 8 caractères de long";
    }   
    elseif ($_POST["new-password"] !== $_POST["conf-new-password"]) {
      $alert = "La confirmation du nouveau mot de passe ne correspond pas à celui qu'il y a au-dessus";
    }   
    elseif (!password_verify(password: $_POST["current-password"], hash: $account["password"])) {
      $alert = "Le mot de passe renseigné dans le champ \"Mot de passe actuel\" ne correspond pas à celui que nous avons";
    } elseif (!Account::updatePasswordByEmail($_SESSION["email"], $_POST["new-password"])) {
      $alert = "Une erreur est survenue lors de la mise à jour";
    }
    
    if (empty($alert)) {    
      header(header: "Location: index.php/?action=login");
      exit;
    }
  }

  include_once "$root/views/changePassword.php";
} else {
  header("Location: ?action=login");
  exit;
}