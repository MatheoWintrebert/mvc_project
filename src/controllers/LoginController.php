<?php
declare(strict_types = 1);

include_once "$root/models/Login.php";

logout();

$errorAlert = "";
if (isset($_POST["email"]) && isset($_POST["password"])) {
    $email = $_POST["email"];
    $password = $_POST["password"];
    login(email: $email, password: $password)["success"] ? header(header: "Location: ?action=profile") : $errorAlert = "Erreur de connexion";
}

include_once "$root/views/login.php";
