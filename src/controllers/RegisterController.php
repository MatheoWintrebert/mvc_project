<?php
declare(strict_types=1);

include_once "$root/models/Register.php";
use Respect\Validation\Validator as v;

$errorAlert = "";
if (
    isset($_POST["email"], $_POST["password"], $_POST["verifyPassword"])
    && v::email()->validate(input: $_POST["email"]) &&
    v::password()->validate(input: $_POST["password"]) &&
    v::password()->validate(input: $_POST["verifyPassword"])
) {
    $email = ($_POST["email"]);
    $password = password_hash(password: $_POST["password"], algo: PASSWORD_DEFAULT);
    $verifyPassword = ($_POST["verifyPassword"]);
    $register->saveAccount(email: $email, password: $password, verifyPassword: $verifyPassword) ? header(header: "Location: ?action=login") : $errorAlert = "Erreur lors de la création du compte";
}

include_once "$root/views/register.php";
