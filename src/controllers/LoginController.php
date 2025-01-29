<?php
declare(strict_types=1);

require_once "$root/models/Login.php";
require_once "$root/helpers/session_helper.php";

use Respect\Validation\Validator as v;
logout();
function validateLoginEmail(string $email): ?string
{
    // Vérifie si l'email est vide
    if (empty($email)) {
        return 'Veuillez remplir l\'adresse mail.';
    }

    // Vérifie si l'email est valide
    if (!v::email()->validate(input: $email)) {
        return 'Adresse email invalide.';
    }

    return null; // Email valide
}

function validateLoginPassword(string $password): ?string
{
    // Vérifie si le mot de passe est vide
    if (empty($password)) {
        return 'Veuillez remplir le champ mot de passe.';
    }

    return null; // Mot de passe valide
}

function loginVerification(): void
{
    // Assainir les entrées de l'utilisateur
    $_POST = array_map(
        callback: fn($value): string => htmlspecialchars(string: $value, flags: ENT_QUOTES, encoding: 'UTF-8'),
        array: $_POST
    );

    // Initialiser les données de connexion
    $email = trim(string: $_POST['email'] ?? '');
    $password = trim(string: $_POST['password'] ?? '');

    // Valider séparément l'email et le mot de passe
    $emailError = validateLoginEmail(email: $email);
    $passwordError = validateLoginPassword(password: $password);

    // Gérer les erreurs d'email ou de mot de passe
    if ($emailError !== null) {
        flash(name: 'login', message: $emailError, type: 'error');
        return;
    }

    if ($passwordError !== null) {
        flash(name: 'login', message: $passwordError, type: 'error');
        return;
    }

    // Vérifier si l'email existe et si le mot de passe correspond
    if (!emailExists(email: $email)) {
        flash(name: 'login', message: 'Cet email n\'existe pas.', type: 'error');
        return;
    }

    if (!isPasswordCorrect(email: $email, password: $password)) {
        flash(name: 'login', message: 'Mot de passe incorrect.', type: 'error');
        return;
    }

    // Connexion réussie
    login(email: $email, password: $password);
    redirect(location: '?action=profile');
}

// Traiter la requête POST pour la connexion
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    loginVerification(); // Appelle la fonction seulement si le bouton "submit" est cliqué
}

require_once "$root/views/login.php";