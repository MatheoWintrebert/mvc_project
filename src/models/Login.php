<?php
class Login
{
    public function searchMail(string $email, string $password): bool
    {
        $bool = false;
        $filepath = "json/accounts.json";

        // Lire les données existantes
        $content = file_get_contents($filepath);
        $data = json_decode($content, true);

        // Vérifier si l'adresse e-mail existe dans les données
        /* @param array<string> $account */
        $bool = (bool) array_filter($data, function (array $account) use ($email, $password):bool {
            return isset($account['email']) && $account['email'] === $email && $this->verifyPassword($account, $password);
        });


        return $bool;
    }
    /* @param array<string> $account */
    public function verifyPassword(array $account, string $password): bool
    {
        return password_verify($account['password'], $password);
    }
}
