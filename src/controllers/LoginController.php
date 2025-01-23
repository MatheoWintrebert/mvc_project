<?php
declare(strict_types=1);
include_once "$root/models/Login.php";
$login = new Login();
$title = "Login";
$errorAlert = "";
if (isset($_POST["email"]) && (isset($_POST["password"]))) {
    $email = ($_POST["email"]);
    $password = password_hash(password: $_POST["password"], algo: PASSWORD_DEFAULT);
    $login->searchMail(email: $email, password: $password) ? header(header: "Location:?action=profile") : $errorAlert = "Erreur de connexion";
}

include_once "$root/views/header.php";
include_once "$root/views/login.php";
include_once "$root/views/footer.php";