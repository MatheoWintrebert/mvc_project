<?php
declare(strict_types=1);
use function _\filter;
use function _\size;
class Register
{
    public function verifyPassword(string $password, string $verifyPassword): bool
    {
        return password_verify(password: $verifyPassword, hash: $password);
    }

    public function verifyEmail(string $email): bool
    {
        $ret = filter_var(value: $email, filter: FILTER_VALIDATE_EMAIL) ? true : false;
        return $ret;
    }

    public function verifyExistingEmail(string $email): bool
    {
        $filepath = "json/accounts.json";

        // Lire les données existantes
        $content = file_get_contents(filename: $filepath);

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



    public function saveAccount(string $email, string $password, string $verifyPassword): bool
    {
        return ($this->verifyEmail(email: $email) && $this->verifyPassword(password: $password, verifyPassword: $verifyPassword) && $this->verifyExistingEmail(email: $email)) === true ? $this->writeAccount(email: $email, password: $password) : false;
    }

    public function writeAccount(string $email, string $password): bool
    {
        $filepath = "json/accounts.json";

        $directory = dirname(path: $filepath);
        if (!is_dir(filename: $directory)) {
            mkdir(directory: $directory, permissions: 0777, recursive: true);
        }

        $data = [];
        if (file_exists(filename: $filepath)) {
            $content = file_get_contents(filename: $filepath);
            $data = json_decode(json: $content, associative: true) ?? [];

            $id = size(collection: $data) + 1;
            $data[$id] = ["email" => $email, "password" => $password];

        }
        $json = json_encode(value: $data, flags: JSON_PRETTY_PRINT);
        return file_put_contents(filename: $filepath, data: $json) !== false;
    }
}
