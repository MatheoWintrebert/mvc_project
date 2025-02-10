<?php
declare(strict_types=1);

function readJSON(): array {
  $filepath = "json/accounts.json";

  try {
    if (!file_exists(filename: $filepath)) {
      throw new RuntimeException(message: "Le fichier JSON est introuvable.");
    }

    $content = file_get_contents(filename: $filepath);
    if ($content === false) {
      throw new RuntimeException(message: "Impossible de lire le fichier JSON.");
    }

    $data = json_decode(json: $content, associative: true, depth: 512, flags: JSON_THROW_ON_ERROR);

    if (!is_array(value: $data)) {
      throw new RuntimeException(message: "Le contenu du fichier JSON est invalide.");
    }

    return $data;
  } catch (Exception $e) {
    error_log(message: "Erreur dans readJSON(): " . $e->getMessage());
    return [];
  }
}

function writeJSON(array $data): bool {
  $filepath = "json/accounts.json";

  try {
    $json = json_encode(value: $data, flags: JSON_PRETTY_PRINT | JSON_THROW_ON_ERROR);
    if (file_put_contents(filename: $filepath, data: $json) === false) {
      throw new RuntimeException(message: "Impossible d'écrire dans le fichier JSON.");
    }

    return true;
  } catch (Exception $e) {
    error_log(message: "Erreur dans writeJSON(): " . $e->getMessage());
    return false;
  }
}
