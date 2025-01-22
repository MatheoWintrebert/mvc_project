<?php
class Login
{
    public function searchMail(string $email, string $password)
    {
        $bool = false;
        $filepath = "json/accounts.json";

        // Lire les données existantes
        $content = file_get_contents($filepath);
        $data = json_decode($content, true);

        // Vérifier si l'adresse e-mail existe dans les données
        foreach ($data as $account) {
            if (isset($account['email']) && $account['email'] === $email) {
                $this->verifyPassword($account, $password);
                $bool = true; // L'adresse e-mail existe déjà
            }
        }

        return $bool;
    }
    public function verifyPassword($account, $password)
    {
        return password_verify($account['password'], $password);
    }
}
