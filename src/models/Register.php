<?php
declare(strict_types=1);

include_once "$root/utils/json.php";
include_once "$root/models/Account.php";

class Register
{
    public static function verifyEmail(string $email): bool
    {
        $pattern = '/^[\\w.-]+@[\\w.-]+\\.[a-zA-Z]{2,4}$/';
        return preg_match(pattern: $pattern, subject: $email) === 1;
    }

    public static function verifyExistingEmail(string $email): bool
    {
        $data = readJSON();
        $exists = array_filter(array: $data, callback: function (array $account) use ($email): bool {
            return isset($account['email']) && $account['email'] === $email;
        });

        return empty($exists); // Retourne true si aucune correspondance n'est trouvée
    }



    public static function saveAccount(string $email, string $password, string $verifyPassword): bool
    {
        return Register::verifyEmail(email: $email) === true ? Register::writeAccount(email: $email, password: $password) : false;
    }

    public static function writeAccount(string $email, string $password): bool
    {
        return Account::createAccount($email, $password);
    }
}
