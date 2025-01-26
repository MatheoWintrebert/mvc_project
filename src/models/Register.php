<?php
declare(strict_types=1);
use function _\size;
use Respect\Validation\Validator as v;

function writeAccount(string $email, string $password): bool
{

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
