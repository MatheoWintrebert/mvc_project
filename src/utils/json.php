<?php
declare(strict_types=1);
use Respect\Validation\Validator as v;

// Si le fichier existe, charger et valider le contenu JSON
function readJSON($filepath): mixed
{
    if (file_exists(filename: $filepath)) {
        $content = file_get_contents(filename: $filepath);
        (v::json()->validate(input: $content)) ?
            $data = json_decode(json: $content, associative: true) ?? []
            :
            $data = [];
    } else {
        $data = [];
    }
    return $data;
}

function writeJSON($data, $filepath): bool
{
    $json = json_encode(value: $data, flags: JSON_PRETTY_PRINT);
    return file_put_contents(filename: $filepath, data: $json) !== false;
}