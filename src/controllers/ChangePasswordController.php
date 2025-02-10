<?php
declare(strict_types=1);

require_once "$root/../vendor/autoload.php";
require_once "$root/models/Account.php";

use Respect\Validation\Validator as v;

if (!isLoggedOn()) {
    header("Location: ?action=login");
    exit;
}

$account = Account::getAccountByEmail($_SESSION["email"]);
$errorAlert = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $currentPassword = $_POST["current-password"] ?? "";
    $newPassword = $_POST["new-password"] ?? "";
    $confirmNewPassword = $_POST["conf-new-password"] ?? "";
    $passwordValidator = v::length(8, null)->notEmpty();
    
    if (empty($currentPassword) || empty($newPassword) || empty($confirmNewPassword)) {
        $errorAlert = "Veuillez remplir l'ensemble des champs.";
    } elseif (!$passwordValidator->validate($newPassword)) {
        $errorAlert = "Le nouveau mot de passe doit contenir au moins 8 caractères.";
    } elseif ($newPassword !== $confirmNewPassword) {
        $errorAlert = "La confirmation du mot de passe ne correspond pas.";
    } elseif (!password_verify($currentPassword, $account["password"])) {
        $errorAlert = "Le mot de passe actuel est incorrect.";
    } else {        
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        
        if (!Account::updatePasswordByEmail($_SESSION["email"], $hashedPassword)) {
            $errorAlert = "Une erreur est survenue lors de la mise à jour du mot de passe.";
        } else {
            header("Location: index.php/?action=login");
            exit;
        }
    }
}

include_once "$root/views/changePassword.php";
