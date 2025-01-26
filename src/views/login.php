<?php declare(strict_types=1); ?>
<div class="container">
    <form id="loginForm" name="loginForm" method="post" action="./?action=login">
        <h1>Se connecter</h1>
        <?php echo $errorAlert !== "" ? '<div class="alert alert-danger" role="alert">' . $errorAlert . '</div>' : ""; ?>
        <div class="mb-3">
            <label for="email" class="form-label">Adresse mail</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="exemple@email.com">
        </div>
        <div class=" mb-3">
            <label for="password" class="form-label">Mot de passe</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="••••••••">
        </div>
        <button type="submit" class="btn btn-primary mb-3">Connexion</button>
    </form>
    <p>Vous n'avez pas de compte ? <a href="?action=register">Créer un compte</a></p>
</div>