<?php declare(strict_types = 1); ?>

<div class="container">
    <form id="registerForm" name="registerForm" method="post" action="./?action=register">
        <h1>Créer un compte</h1>
        <?php if ($alert = Alert::getFromSession()): ?>
            <?= $alert->render(); ?>
            <?php Alert::clear(); ?>
        <?php endif; ?>
        <div class="mb-3">
            <label for="email" class="form-label">Adresse mail</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="exemple@email.com" />
        </div>
        <div class=" mb-3">
            <label for="password" class="form-label">Mot de passe</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="••••••••" />
        </div>
        <div class=" mb-3">
            <label for="verifyPassword" class="form-label">Vérifier le mot de passe</label>
            <input type="password" class="form-control" id="verifyPassword" name="verifyPassword" placeholder="••••••••" />
        </div>
        <button type="submit" class="btn btn-primary mb-3">Envoyer</button>
    </form>
    <p>Déjà un compte ? <a href="?action=login">Se connecter</a></p>
</div>