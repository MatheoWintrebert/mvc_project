<?php
session_start();
require_once dirname(__DIR__, 2) . '/vendor/autoload.php';
require_once __DIR__ . '/../models/GameModel.php';

$model = new GameModel();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['reset'])) {
        $model->resetGame();
    } elseif (isset($_POST['refresh'])) {
        $model->refreshGame();
    } elseif (isset($_POST['actorSearch']) && isset($_POST['movieSearch'])) {
        $actor3 = $_POST['actorSearch'];
        $movie = $_POST['movieSearch'];
        $result = $model->validateActorConnection($_SESSION['actor1'], $actor3, $movie);
    }
}

$model->initializeGame();


$actor2 = $_SESSION['actor2'] ?? ''; // Retrieve actor2 from session
$actor3 = $_POST['actorSearch'] ?? ''; // Get actorSearch from POST

// Initialize the path in session if it doesn’t exist
if (!isset($_SESSION['path'])) {
    $_SESSION['path'] = [$_SESSION['actor1'] ?? '']; // Ensure actor1 is set
}

// Get the last actor from the path
$actor1 = end($_SESSION['path']);

require_once __DIR__ . '/../views/GameView.php';
