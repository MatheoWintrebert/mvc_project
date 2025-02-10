<?php
declare(strict_types=1);

require_once "$root/../vendor/autoload.php";
require_once "$root/models/Login.php";

use Respect\Validation\Validator as v;

logout();

$errorAlert = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST["email"] ?? "";
    $password = $_POST["password"] ?? "";

    // Validation Respect\Validation
    $emailValidator = v::email()->notEmpty();
    $passwordValidator = v::notEmpty();

    if (!$emailValidator->validate($email)) {
        $errorAlert = "L'email est invalide.";
    } elseif (!$passwordValidator->validate($password)) {
        $errorAlert = "Le mot de passe ne peut pas être vide.";
    } else {
        $loginResult = login(email: $email, password: $password);

        if ($loginResult["success"]) {
            header("Location: ?action=profile");
            exit;
        } else {
            $errorAlert = "Erreur de connexion.";
        }
    }
}

include_once "$root/views/login.php";
