<?php
declare(strict_types=1);

include_once "$root/models/Login.php";
include_once "$root/helpers/session_helper.php";
use Respect\Validation\Validator as v;
$errorAlert = "";
if (
    isset($_POST["email"], $_POST["password"]) &&
    v::email()->validate(input: $_POST["email"]) &&
    v::password()->validate(input: $_POST["password"])
) {
    $email = ($_POST["email"]);
    $password = password_hash(password: $_POST["password"], algo: PASSWORD_DEFAULT);
    $login->searchMail(email: $email, password: $password) ? header(header: "Location:?action=profile") : $errorAlert = "Erreur de connexion";
}

include_once "$root/views/login.php";
