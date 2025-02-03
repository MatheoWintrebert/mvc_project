<?php
declare(strict_types = 1);

include_once "$root/utils/json.php";

class Account {
  /**
   * Recupère le compte en fonction de l'email passée en paramètre
   * @param string $email
   * @return array{email: string, password: string}
   */
  public static function getAccountByEmail(string $email): ?array {
    $data = readJSON();
    $found = array_filter($data, fn(array $account) => $account["email"] === $email);
    
    return $found ? array_values($found)[0] : null;
}

  public static function createAccount($email, $password) {
    $data = readJSON();
    $data[] = [
      "email" => $email,
      "password" => $password
    ];
  
    $json = json_encode($data, JSON_PRETTY_PRINT);
    return writeJSON($json);
  }
  
  public static function updatePasswordByEmail(string $email, string $password): bool {
    $filepath = "json/accounts.json";
    $data = readJSON();
    $updatedData = array_map(function ($account) use ($email, $password) {
        if ($account["email"] === $email) {
            $account["password"] = password_hash($password, PASSWORD_DEFAULT);
        }
        return $account;
    }, $data);

    $json = json_encode($updatedData, JSON_PRETTY_PRINT);
    return writeJSON($json);
  }
}