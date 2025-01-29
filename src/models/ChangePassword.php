<?php
declare(strict_types=1);
function updatePassword(string $email, string $newPassword): bool
{
    $filepath = "json/accounts.json";

    $directory = dirname(path: $filepath);
    if (!is_dir(filename: $directory)) {
        mkdir(directory: $directory, permissions: 0777, recursive: true);
    }

    // Recuperer les données du fichier
    $data = readJSON(filepath: $filepath) ?? [];
    $modifiedData = array_map(
        callback: fn($account): mixed => $account['email'] === $email ? array_merge($account, ['password' => $newPassword]) : $account,
        array: $data
    );

    // Écrire le tableau mis à jour dans le fichier
    return writeJSON(data: $modifiedData, filepath: $filepath);
}