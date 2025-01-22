<?php
include_once "$root/models/Register.php";
$register = new Register();
$title = "Register";
$errorAlert = "";
if ((isset($_POST["email"])) && (isset($_POST["password"])) && (isset($_POST["verifyPassword"]))) {
    $email = ($_POST["email"]);
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
    $verifyPassword = ($_POST["verifyPassword"]);
    $register->saveAccount($email, $password, $verifyPassword) ? header("Location: ?action=login") : $errorAlert = "Erreur lors de la création du compte";
}
include_once "$root/views/header.php";
include_once "$root/views/register.php";
include_once "$root/views/footer.php";
