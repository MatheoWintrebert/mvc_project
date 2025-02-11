<?php

//session_start();

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jeu des Acteurs</title>
    <link rel="stylesheet" href="/mvc_project/public/css/style.css">
</head>

<body>

    <h1>Trouve un lien entre ces deux acteurs aléatoires !</h1>

    <?php if (!empty($result)): ?>
        <div class="<?= key($result) ?>"><?= current($result) ?></div>
    <?php endif; ?>

    <div class="actorContainer">
        <?php foreach ($_SESSION['path'] as $index => $item): ?>
            <div class="actorName <?= $index === 0 ? 'firstActor' : ($index % 2 !== 0 ? 'movie' : ''); ?>">
                <?= htmlspecialchars($item) ?>
            </div>
            <?php if ($item !== end($_SESSION['path'])): ?>
                <div class="connector"></div>
            <?php endif; ?>
        <?php endforeach; ?>
        <?php if (end($_SESSION['path']) !== $actor2): ?>
            <div class="connector dashed"></div>
            <div class="actorName"><?= $actor2 ?></div>
        <?php else: ?>
            <div class="congratulations">
                Félicitations! Vous avez trouvé un lien entre les deux acteurs en <?= (count($_SESSION['path']) - 3) / 2 ?>
                étapes.
            </div>
        <?php endif; ?>
    </div>

    <form method="POST">
        <div class="autocomplete"><input type="text" name="actorSearch" placeholder="Entrez un acteur"
                onkeyup="searchActor()"></div>
        <div class="autocomplete"><input type="text" name="movieSearch" placeholder="Recherchez un film"
                onkeyup="searchMovie()"></div>
        <button class="submit" type="submit">Submit</button>
    </form>

    <form class="buttonForm" method="POST">
        <button class="smallRoundButton" type="submit" name="refresh">⟳</button>
        <button class="smallRoundButton" type="submit" name="reset">🗑️</button>
    </form>

    <script src="/mvc_project/public/js/autocomplete.js"></script>
</body>

</html>