<?php
declare(strict_types = 1);

include_once "$root/utils/json.php";

class Account {
  private string $email;
  private string $password;

  // Le constructeur pour initialiser l'email et le mot de passe
  public function __construct(string $email, string $password) {
    $this->email = $email;
    $this->password = $password;
  }

  // Getter pour l'email
  public function getEmail(): string {
    return $this->email;
  }

  // Getter pour le mot de passe
  public function getPassword(): string {
    return $this->password;
  }

  /**
   * Recupère le compte en fonction de l'email passée en paramètre
   * @param string $email
   * @return Account | null
   */
  public static function getAccountByEmail(string $email): ?Account {
    $data = readJSON();
    $found = array_filter($data, fn(array $account) => $account["email"] === $email);
    
    if (count($found) > 0) {
      $accountData = array_values($found)[0];
      return new Account($accountData["email"], $accountData["password"]);
    }

    return null;
  } 
  
  /**
   * Change le mot de passe de l'utilisateur en fonction du mail renseigné
   * @param string $email
   * @param string $hashedPassword
   * @return bool
   */
  public static function updatePasswordByEmail(string $email, string $hashedPassword): bool {
    $data = readJSON();
    $updatedData = array_map(function ($account) use ($email, $hashedPassword) {
      if ($account["email"] === $email) {
        $account["password"] = $hashedPassword;
      }
      return $account;
    }, $data);

    $json = json_encode($updatedData, JSON_PRETTY_PRINT);
    return writeJSON($json);
  }

  /**
   * Permet de créer un compte
   * @param string $email
   * @param string $password
   * @return bool
   */
  private static function saveAccount(string $email, string $password): bool {
    $data = readJSON();
    $data[] = [
      "email" => $email,
      "password" => $password
    ];
    
    $json = json_encode(value: $data, flags: JSON_PRETTY_PRINT);
    return writeJSON(json: $json);
  }

  /**
   * Permet de sauvegarder les 
   * @param string $email
   * @param string $password
   * @return bool
   */
  public static function createAccount(string $email, string $password): bool
  {
    return Account::getAccountByEmail(email: $email) === null ? Account::saveAccount(email: $email, password: $password) : false;
  }
}