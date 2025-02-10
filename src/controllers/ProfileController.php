<?php
declare(strict_types = 1);

if (isLoggedOn()) {
  $email = $_SESSION["email"];
  $nbWonGames = 19;
  $nbInProgressGames = 3;

  // Pour l'avoir il faut rechercher pour l'emsemble des utils le nombre de game gagnée et faire un ORDER BY (enfin je crois, de tête et sans BDD compliqué de sortir des requêtes SQL)
  $currentRank = 1;

  include_once "$root/views/profile.php";
} else {
  header(header: "Location: ?action=login");
  exit;
}
