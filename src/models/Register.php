<?php
declare(strict_types=1);
use function _\filter;
use function _\size;
use Respect\Validation\Validator as v;
function verifyPassword(string $password, string $verifyPassword): bool
{
    return password_verify(password: $verifyPassword, hash: $password);
}

function verifyEmail(string $email): bool
{
    $ret = filter_var(value: $email, filter: FILTER_VALIDATE_EMAIL) ? true : false;
    return $ret;
}

function verifyExistingEmail(string $email): bool
{
    if (!v::email()->validate(input: $email)) {
        return false; // Return false if the email is invalid
    }

    $filepath = "json/accounts.json";

    if (!file_exists(filename: $filepath)) {
        return true; // If the file doesn't exist, return true (indicating no email exists)
    }
    // Lire les données existantes
    $content = file_get_contents(filename: $filepath);

    // Validate the JSON format using Respect/Validation
    if (!v::json()->validate(input: $content)) {
        return false; // Return false if the JSON is invalid
    }
    // Décoder le contenu JSON
    $data = json_decode(json: $content, associative: true);

    // Si les données ne sont pas un tableau, les initialiser comme un tableau vide
    $data = $data ?? [];

    // Vérifier si l'adresse e-mail existe dans les données
    $exists = filter(array: $data, predicate: function (array $account) use ($email): bool {
        return isset($account['email']) && $account['email'] === $email;
    });

    return empty($exists); // Retourne true si aucune correspondance n'est trouvée
}



function saveAccount(string $email, string $password, string $verifyPassword): bool
{
    return (verifyEmail(email: $email) && verifyPassword(password: $password, verifyPassword: $verifyPassword) && verifyExistingEmail(email: $email)) === true ? writeAccount(email: $email, password: $password) : false;
}

function writeAccount(string $email, string $password): bool
{
    if (!v::email()->validate(input: $email)) {
        return false; // Return false if the email is invalid
    }

    if (!v::stringType()->notEmpty()->length(8, null)->validate($password)) {
        return false; // Return false if the password is invalid
    }

    $filepath = "json/accounts.json";

    $directory = dirname(path: $filepath);
    if (!is_dir(filename: $directory)) {
        mkdir(directory: $directory, permissions: 0777, recursive: true);
    }

    $data = [];

    if (file_exists(filename: $filepath)) {
        $content = file_get_contents(filename: $filepath);
        if (!v::json()->validate(input: $content)) {
            return false; // Return false if the JSON is invalid
        }

        $data = json_decode(json: $content, associative: true) ?? [];

        $id = size(collection: $data) + 1;
        $data[$id] = ["email" => $email, "password" => $password];

    } else {
        // If file doesn't exist, start with an empty array and add the first account
        $id = 1;
        $data[$id] = ["email" => $email, "password" => $password];
    }
    $json = json_encode(value: $data, flags: JSON_PRETTY_PRINT);
    return file_put_contents(filename: $filepath, data: $json) !== false;
}
