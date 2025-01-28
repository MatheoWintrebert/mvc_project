<?php
declare(strict_types=1);
include_once "$root/models/Account.php";
// Helper function to check if email exists
function emailExists(string $email): bool
{
    $filepath = "json/accounts.json";

    if (!file_exists(filename: $filepath)) {
        return false;
    }

    $content = file_get_contents(filename: $filepath);
    $accounts = json_decode(json: $content, associative: true) ?? [];

    return !empty(array_filter(
        array: $accounts,
        callback: fn($account): bool => isset($account['email']) && $account['email'] === $email
    ));
}

// Helper function to verify password
function isPasswordCorrect(string $email, string $password): bool
{
    $filepath = "json/accounts.json";

    // Vérifier si le fichier existe
    if (!file_exists(filename: $filepath)) {
        flash(name: 'login', message: 'Fichier des comptes introuvable.', type: 'error');
        return false;
    }

    // Lire le contenu du fichier JSON
    $content = file_get_contents(filename: $filepath);
    $accounts = json_decode(json: $content, associative: true) ?? [];

    // Recherche du compte avec l'email donné
    $account = current(array: array_filter(
        array: $accounts,
        callback: fn($account): bool => isset($account['email']) && $account['email'] === $email
    ));

    // Vérifier si le compte existe
    if (!$account) {
        flash(name: 'login', message: 'Aucun compte trouvé avec cet email.', type: 'error');
        return false; // Compte non trouvé
    }

    // Vérifier si le mot de passe existe dans le compte
    if (!isset($account['password'])) {
        flash(name: 'login', message: 'Mot de passe introuvable pour cet utilisateur.', type: 'error');
        return false; // Mot de passe inexistant
    }

    // Vérification du mot de passe avec password_verify
    if (password_verify(password: $password, hash: $account['password']) === false) {
        flash(name: 'login', message: 'Mot de passe incorrect.', type: 'error');
        return false; // Mot de passe incorrect
    }

    // Si tout va bien, on retourne true
    return true; // Mot de passe correct
}

/**
 * Permet de login l'utilisateur
 * @param string $email
 * @param string $password
 * @return array{success: bool, email: null|string, password: null|string}
 */
function login(string $email, string $password): array
{
    $account = Account::getAccountByEmail(email: $email);
    $emailAccount = $account["email"];
    $passwordAccount = $account["password"];

    if (session_start() && $emailAccount === $email && password_verify(password: $password, hash: $passwordAccount)) {
        $_SESSION["email"] = $account["email"];
        $_SESSION["password"] = $account["password"];
    }

    var_dump(value: $_SESSION);

    return ["success" => isset($_SESSION["email"]) && isset($_SESSION["password"]), "email" => $_SESSION["email"] ?? null, "password" => $_SESSION["password"] ?? null];
}

/**
 * Permet de déconnecter l'utilisateur
 * @return void
 */
function logout(): void
{
    if (!isset($_SESSION)) {
        session_start();
    }
    unset($_SESSION["email"]);
    unset($_SESSION["password"]);
}

/**
 * Détermine si le user est connecté
 * @return bool
 */
function isLoggedOn(): bool
{
    if (!isset($_SESSION)) {
        session_start();
    }

    if (empty($_SESSION["email"]) || empty($_SESSION["password"])) {
        return false;
    }

    $account = Account::getAccountByEmail($_SESSION["email"]);
    // return $account && $account["email"] === $_SESSION["email"] && $account["password"] === $_SESSION["password"];


    return empty($_SESSION["email"]) || empty($_SESSION["password"]) ?
        false :
        Account::getAccountByEmail($_SESSION["email"])["email"] === $_SESSION["email"] &&
        Account::getAccountByEmail($_SESSION["email"])["password"] === $_SESSION["password"];
}