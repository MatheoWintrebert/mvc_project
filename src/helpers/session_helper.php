<?php
if (!isset($_SESSION)) {
    session_start();
}

/**
 * Gère les messages flash pour afficher des notifications temporaires.
 *
 * @param string $name    Le nom du message flash (clé pour l'enregistrement dans la session).
 * @param string $message Le contenu du message flash (facultatif pour afficher uniquement).
 * @param string $type    Le type du message (success, error, info, warning).
 */
function flash(string $name, string $message = '', string $type = 'error'): void
{
    // Si un message est fourni, on le stocke dans la session
    if (!empty($message)) {
        $_SESSION['flash'][$name] = [
            'message' => $message,
            'type' => $type,
        ];
    }
    // Si aucun message n'est fourni, on affiche et supprime le message existant
    elseif (isset($_SESSION['flash'][$name])) {
        /**
         * @var string[] $flash
         */
        $flash = $_SESSION['flash'][$name];
        $class = match ($flash['type']) {
            'success' => 'success',
            'info' => 'info',
            'warning' => 'warning',
            'error' => 'danger',
            default => 'danger', // Par défaut, type "error"
        };
        echo '<div class="alert alert-' . $class . ' alert-dismissible fade show">' . htmlspecialchars(string: $flash['message'], flags: ENT_QUOTES, encoding: 'UTF-8') . '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
        unset($_SESSION['flash'][$name]); // Supprime le message après affichage
    }
}

function redirect(string $location): never
{
    // Perform redirection
    header(header: "Location: " . $location);
    exit();
}
