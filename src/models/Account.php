<?php
declare(strict_types=1);

include_once "$root/utils/json.php";

class Account
{
    /**
     * Recupère le compte en fonction de l'email passée en paramètre
     * @param string $email
     * @return array{email: string, password: string}
     */
    public static function getAccountByEmail(string $email): mixed
    {
        $data = readJSON(filepath: $filepath = "json/accounts.json");
        $found = array_filter(array: $data, callback: function (array $account) use ($email): bool {
            return $account["email"] === $email;
        });

        return $found[array_key_first(array: $found)];
    }

    public static function createAccount($email, $password): bool
    {
        $data = readJSON(filepath: $filepath = "json/accounts.json");
        $data[] = [
            "email" => $email,
            "password" => $password
        ];

        $json = json_encode(value: $data, flags: JSON_PRETTY_PRINT);
        return writeJSON(data: $json, filepath: $filepath = "json/accounts.json");
    }

    public static function updatePasswordByEmail(string $email, string $password): bool
    {
        $filepath = "json/accounts.json";
        $data = readJSON(filepath: $filepath = "json/accounts.json");
        $updatedData = array_map(callback: function ($account) use ($email, $password): mixed {
            if ($account["email"] === $email) {
                $account["password"] = password_hash(password: $password, algo: PASSWORD_DEFAULT);
            }
            return $account;
        }, array: $data);

        $json = json_encode(value: $updatedData, flags: JSON_PRETTY_PRINT);
        return writeJSON(data: $json, filepath: $filepath = "json/accounts.json");
    }
}