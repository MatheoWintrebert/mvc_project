<?php
declare(strict_types=1);

require_once "$root/models/Register.php";
require_once "$root/utils/json.php";
require_once "$root/helpers/session_helper.php";

use Respect\Validation\Validator as v;

use function _\filter;

function isEmailValid(string $email): bool
{
    return v::email()->validate(input: $email);
}

function doesFileExist(string $filepath): bool
{
    return file_exists(filename: $filepath);
}

function getFileContent(string $filepath): string
{
    // Lire le contenu du fichier et retourner une chaîne vide s'il est vide ou inaccessible
    return file_get_contents(filename: $filepath) ?: '';
}

function isJsonValid(string $jsonContent): bool
{
    // Considérer une chaîne vide comme JSON valide car elle représente un tableau vide par défaut
    return empty($jsonContent) || v::json()->validate(input: $jsonContent);
}

function decodeJson(string $jsonContent): array
{
    // Si le contenu est vide, retourner un tableau vide, sinon décoder le JSON
    return empty($jsonContent) ? [] : (json_decode(json: $jsonContent, associative: true) ?? []);
}

function isEmailAlreadyExists(string $email, array $accounts): bool
{
    // Utilisation de la fonction filter de lodash
    $filteredAccounts = filter(array: $accounts, predicate: fn($account): bool => isset($account['email']) && $account['email'] === $email);
    return !empty($filteredAccounts);
}

function validateEmail(array $data): ?string
{
    $email = $data['email'] ?? '';

    if (empty($email)) {
        return 'Veuillez remplir l\'adresse mail';
    }

    if (!isEmailValid(email: $email)) {
        return 'Format d\'email incorrect.';
    }

    $filepath = "json/accounts.json";

    if (!doesFileExist(filepath: $filepath)) {
        return null; // Si le fichier n'existe pas, l'email est valide
    }

    $content = getFileContent(filepath: $filepath);

    if (!isJsonValid(jsonContent: $content)) {
        return 'Erreur de format du fichier JSON.';
    }

    $accounts = decodeJson(jsonContent: $content);

    if (isEmailAlreadyExists(email: $email, accounts: $accounts)) {
        return 'L\'email est déjà utilisé.';
    }

    return null; // L'email est valide
}

// Validation du mot de passe
function validatePassword(array $data): ?string
{
    return empty($data['password']) ? 'Veuillez remplir le champ mot de passe.' :
        (v::stringType()->length(min: 6)->validate(input: $data['password']) ? null : 'Le mot de passe doit contenir au moins 6 caractères.');
}

// Validation de la confirmation de mot de passe
function validateVerifyPassword(array $data): ?string
{
    return empty($data['verifyPassword']) ? 'Veuillez confirmer votre mot de passe.' :
        ($data['password'] !== $data['verifyPassword'] ? 'Les mots de passe ne sont pas les mêmes.' : null);
}

function validate(array $data): ?string
{
    // Liste des fonctions de validation
    $validations = [
        'validateEmail',
        'validatePassword',
        'validateVerifyPassword',
    ];

    // Utiliser array_reduce pour trouver la première erreur
    return array_reduce(array: $validations, callback: function ($acc, $validation) use ($data): ?string {
        // Si une erreur a déjà été trouvée, on la retourne directement
        if ($acc !== null) {
            return $acc;
        }
        // Appliquer la validation et retourner la première erreur rencontrée
        return $validation($data);
    }, initial: null); // initialiser l'accumulateur avec null (pas d'erreur au début)
}

function register(): void
{
    // Échapper les données de $_POST
    $_POST = array_map(callback: fn($value): string => htmlspecialchars(string: $value, flags: ENT_QUOTES, encoding: 'UTF-8'), array: $_POST);

    // Initialiser les données
    $data = [
        'email' => trim(string: $_POST['email'] ?? ''),
        'password' => trim(string: $_POST['password'] ?? ''),
        'verifyPassword' => trim(string: $_POST['verifyPassword'] ?? ''),
    ];

    // Exécution de la validation
    $error = validate(data: $data);

    // Gestion des erreurs
    if ($error !== null) {
        flash(name: 'register', message: $error, type: 'error');
        return; // Arrêt de l'exécution si erreur
    }

    // Traitement des données si tout est valide
    $email = $data['email'];
    $password = password_hash(password: $data['password'], algo: PASSWORD_DEFAULT);

    // Enregistrer le compte
    if (writeAccount(email: $email, password: $password) === true) {
        flash(name: 'login', message: 'Compte créé avec succès ! Veuillez vous connecter.', type: 'success');
        redirect(location: '?action=login');
    } else {
        flash(name: 'register', message: 'Une erreur est survenue lors de la création du compte.', type: 'error');
        return;
    }
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    register(); // Appelle la fonction seulement si le bouton "submit" est cliqué
}

require_once "$root/views/register.php";