<?php
class Register
{
    public function verifyPassword(string $password, string $verifyPassword): bool
    {
        return password_verify($verifyPassword, $password);
    }

    public function verifyEmail(string $email): bool
    {
        $pattern = '/^[\\w.-]+@[\\w.-]+\\.[a-zA-Z]{2,4}$/';
        return preg_match($pattern, $email) === 1;
    }

    public function verifyExistingEmail(string $email): bool
    {
        $bool = true;
        $filepath = "json/accounts.json";

        // Lire les données existantes
        $content = file_get_contents($filepath);
        $data = json_decode($content, true);

        // Vérifier si l'adresse e-mail existe dans les données
        $bool = !array_filter($data, function (array $account) use ($email): bool {
            return isset($account['email']) && $account['email'] === $email;
        });

        return $bool;
    }


    public function saveAccount(string $email, string $password, string $verifyPassword): bool
    {
        return ($this->verifyEmail($email) && $this->verifyPassword($password, $verifyPassword) && $this->verifyExistingEmail($email)) === true ? $this->writeAccount($email, $password) : false;
    }

    public function writeAccount(string $email, string $password): bool
    {
        $filepath = "json/accounts.json";

        $directory = dirname($filepath);
        if (!is_dir($directory)) {
            mkdir($directory, 0777, true);
        }

        $data = [];
        if (file_exists($filepath)) {
            $content = file_get_contents($filepath);
            $data = json_decode($content, true) ?? [];
        }

        $id = count($data) + 1;
        $data[$id] = ["email" => $email, "password" => $password];

        $json = json_encode($data, JSON_PRETTY_PRINT);
        return file_put_contents($filepath, $json) !== false;
    }
}
