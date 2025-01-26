<?php
declare(strict_types=1);
use Respect\Validation\Validator as v;

function writeAccount(string $email, string $password): bool
{
    $filepath = "json/accounts.json";

    $directory = dirname(path: $filepath);
    if (!is_dir(filename: $directory)) {
        mkdir(directory: $directory, permissions: 0777, recursive: true);
    }

    $data = []; // Par défaut, un tableau vide

    // Si le fichier existe, charger et valider le contenu JSON
    if (file_exists(filename: $filepath)) {
        $content = file_get_contents(filename: $filepath);
        if (v::json()->validate(input: $content)) {
            $data = json_decode(json: $content, associative: true) ?? [];
        }
    }

    // Ajouter un nouveau compte au tableau
    $hashedPassword = password_hash(password: $password, algo: PASSWORD_BCRYPT); // Hachage du mot de passe
    $data[] = [
        "email" => $email,
        "password" => $hashedPassword,
    ];

    // Écrire le tableau mis à jour dans le fichier
    $json = json_encode(value: $data, flags: JSON_PRETTY_PRINT);
    return file_put_contents(filename: $filepath, data: $json) !== false;
}
