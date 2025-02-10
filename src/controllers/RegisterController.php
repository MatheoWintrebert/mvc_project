<?php
declare(strict_types=1);

require_once "$root/../vendor/autoload.php";
require_once "$root/models/Register.php";

use Respect\Validation\Validator as v;

$errorAlert = "";

// Vérifie si le formulaire est soumis
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST["email"] ?? "";
    $password = $_POST["password"] ?? "";
    $verifyPassword = $_POST["verifyPassword"] ?? "";

    $emailValidator = v::email()->notEmpty();
    $passwordValidator = v::length(8, null)->notEmpty();

    if (!$emailValidator->validate($email)) {
        $errorAlert = "L'email est invalide.";
    } elseif (!$passwordValidator->validate($password)) {
        $errorAlert = "Le mot de passe doit contenir au moins 8 caractères.";
    } elseif ($password !== $verifyPassword) {
        $errorAlert = "Les champs concernant les mots de passe ne sont pas identiques.";
    } else {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        
        if (Register::saveAccount(email: $email, password: $hashedPassword)) {
            header("Location: ?action=login");
            exit;
        } else {
            $errorAlert = "Erreur lors de la création du compte.";
        }
    }
}

include_once "$root/views/register.php";
