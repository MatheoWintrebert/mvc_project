<?php
$title = "Profile";

$username = "Zerdov";
$nbWonGames = 19828387615617187192192791721972;
$nbInProgressGames = 8753;

// Pour l'avoir il faut rechercher pour l'emsemble des utils le nombre de game gagnée et faire un ORDER BY (enfin je crois, de tête et sans BDD compliqué de sortir des requêtes SQL)
$currentRank = 1;

include_once "$root/views/profile.php";
