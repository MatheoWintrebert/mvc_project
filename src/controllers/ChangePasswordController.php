<?php
$hashed_password = password_hash("azertyui", PASSWORD_BCRYPT);

$error_message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {  
  if (
    empty($_POST["current-password"]) ||
    empty($_POST["new-password"]) ||
    empty($_POST["conf-new-password"])
  ) {
    $error_message = "Veuillez remplir l'ensemble des champs";
  }   
  elseif (strlen(string: $_POST["new-password"]) < 8) {
    $error_message = "Le nouveau mot de passe doit faire plus de 8 caractères de long";
  }   
  elseif ($_POST["new-password"] !== $_POST["conf-new-password"]) {
    $error_message = "La confirmation du nouveau mot de passe ne correspond pas à celui qu'il y a au-dessus";
  }   
  elseif (!password_verify(password: $_POST["current-password"], hash: $hashed_password)) {
    $error_message = "Le mot de passe renseigné dans le champ \"Mot de passe actuel\" ne correspond pas à celui que nous avons";
  }
  
  if (empty($error_message)) {    
    header(header: "Location: index.php/?action=login");
    exit;
  }
}

include_once "$root/views/changePassword.php";
