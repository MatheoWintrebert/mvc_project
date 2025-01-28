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

    // Recuperer les données du fichier
    $data = readJSON(filepath: $filepath) ?? [];

    // Ajouter un nouveau compte au tableau
    $data[] = [
        "email" => $email,
        "password" => $password,
    ];
    // Écrire le tableau mis à jour dans le fichier
    return writeJSON(data: $data, filepath: $filepath);
}
