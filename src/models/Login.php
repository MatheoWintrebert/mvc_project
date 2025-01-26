<?php
declare(strict_types=1);

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
