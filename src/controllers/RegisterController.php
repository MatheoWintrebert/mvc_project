<?php
declare(strict_types = 1);

include_once "$root/models/Register.php";

$errorAlert = "";
if (isset($_POST["email"]) && isset($_POST["password"]) && isset($_POST["verifyPassword"])) {
    $email = $_POST["email"];
    $password = password_hash(password: $_POST["password"], algo: PASSWORD_DEFAULT);
    $verifyPassword = $_POST["verifyPassword"];
    Register::saveAccount(email: $email, password: $password, verifyPassword: $verifyPassword) ? header(header: "Location: ?action=login") : $errorAlert = "Erreur lors de la création du compte";
}

include_once "$root/views/register.php";
