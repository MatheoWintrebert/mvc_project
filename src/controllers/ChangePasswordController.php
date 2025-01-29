<?php
declare(strict_types=1);

require_once "$root/helpers/session_helper.php";
require_once "$root/models/Login.php";
require_once "$root/models/ChangePassword.php";

use Respect\Validation\Validator as v;
function validateCurrent($data): ?string
{
  return empty($data['currentPassword']) ? 'Veuillez remplir le mot de passe actuel' :
    (isPasswordCorrect(email: $_SESSION['email'], password: $data['currentPassword']) ? null : 'Mot de passe incorrect');
}

function validateNew($data): ?string
{
  return empty($data['newPassword']) ? 'Veuillez remplir le nouveau mot de passe' :
    (v::stringType()->length(min: 6)->validate(input: $data['newPassword']) ? null : 'Le nouveau mot de passe doit contenir au moins 6 caractères');
}

function validateConf($data): ?string
{
  return empty($data['confNewPassword']) ? 'Veuillez confirmer le nouveau mot de passe' :
    ($data['newPassword'] === $data['confNewPassword'] ? null : 'Les mots de passe ne sont pas les mêmes');
}

/**
 * Summary of validate
 * @param string[] $data
 */
function validate(array $data): ?string
{
  $validations = [
    'validateCurrent',
    'validateNew',
    'validateConf',
  ];

  return array_reduce(array: $validations, callback: function (?string $acc, $validation) use ($data): ?string {
    return $acc ?? $validation(data: $data);
  });
}

function changePasswordVerification(): void
{
  $_POST = array_map(
    callback: fn($value): string => htmlspecialchars(string: $value, flags: ENT_QUOTES, encoding: "UTF-8"),
    array: $_POST
  );

  // Initialiser les données de connexion
  $data = [
    'currentPassword' => trim(string: $_POST['current-password'] ?? ''),
    'newPassword' => trim(string: $_POST['new-password'] ?? ''),
    'confNewPassword' => trim(string: $_POST['conf-new-password'] ?? ''),
  ];

  $error = validate(data: $data);
  if ($error !== null) {
    flash(name: 'changePassword', message: $error, type: 'error');
    return;
  }
  $newPassword = password_hash(password: $data['newPassword'], algo: PASSWORD_DEFAULT);
  if (updatePassword(email: $_SESSION['email'], newPassword: $newPassword) === true) {
    flash(name: 'login', message: 'Mot de passe modifié avec succès! Veuillez vous connecter', type: 'success');
    redirect(location: '?action=login');
  } else {
    flash(name: 'changePassword', message: 'Erreur lors de la modification du mot de passe', type: 'error');
    return;
  }
}
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['submit'])) {
  changePasswordVerification();
}

include_once "$root/views/changePassword.php";
