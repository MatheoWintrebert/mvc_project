<?php
declare(strict_types=1);

include_once "$root/utils/json.php";
include_once "$root/models/Account.php";

class Register
{
    /**
     * Permet de vérifier si l'email existe déjà ou non
     * @param string $email
     * @return bool
     */
    public static function verifyExistingEmail(string $email): bool
    {
        $data = readJSON();
        $exists = array_filter(array: $data, callback: function (array $account) use ($email): bool {
            return isset($account['email']) && $account['email'] === $email;
        });

        return empty($exists); // Retourne true si aucune correspondance n'est trouvée
    }

    /**
     * Permet de sauvegarder les 
     * @param string $email
     * @param string $password
     * @return bool
     */
    public static function saveAccount(string $email, string $password): bool
    {
        return Register::verifyExistingEmail(email: $email) !== true ? Register::writeAccount(email: $email, password: $password) : false;
    }

    public static function writeAccount(string $email, string $password): bool
    {
        return Account::createAccount($email, $password);
    }
}
