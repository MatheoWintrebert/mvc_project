<?php
declare(strict_types=1);

use function _\filter;
function searchMail(string $email, string $password): bool
{
    $bool = false;
    $filepath = "json/accounts.json";
    if (!file_exists(filename: $filepath)) {
        return false; // Return false if the file doesn't exist
    }
    $content = file_get_contents(filename: $filepath);
    // Validate the JSON using Respect/Validation
    $jsonValidator = Respect\Validation\Validator::json()->validate(input: $content);
    if (!$jsonValidator) {
        return false; // Return false if JSON is invalid
    }
    // Lire les données existantes
    $data = json_decode(json: $content, associative: true);

    $arrayValidator = Respect\Validation\Validator::arrayType()->each(
        rule: Respect\Validation\Validator::arrayType()->keySet(
            Respect\Validation\Validator::key(reference: 'email', referenceValidator: Respect\Validation\Validator::email()),
            Respect\Validation\Validator::key(reference: 'password', referenceValidator: Respect\Validation\Validator::stringType()->notEmpty())
        )
    );
    if (!$arrayValidator->validate(input: $data)) {
        return false;
    }
    // Vérifier si l'adresse e-mail existe dans les données
    /* @param array<string> $account */
    $bool = filter(array: $data, predicate: function (array $account) use ($email, $password): bool {
        return isset($account['email'])
            && $account['email'] === $email
            && verifyPassword(account: $account, password: $password);
    });
    return !empty($bool);
}
/* @param array<string> $account */
function verifyPassword(array $account, string $password): bool
{
    return password_verify(password: $account['password'], hash: $password);
}

