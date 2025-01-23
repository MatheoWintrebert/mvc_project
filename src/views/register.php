<?php declare(strict_types=1); ?>

<body>
    <?php echo $errorAlert !== "" ? '<div class="alert alert-danger" role="alert">' . $errorAlert . '</div>' : ""; ?>
    <form id="registerForm" name="registerForm" method="post" action="./?action=register">
        <div class="mb-3">
            <label for="email" class="form-label">Adresse mail</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="exemple@email.com">
        </div>
        <div class=" mb-3">
            <label for="password" class="form-label">Mot de passe</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="••••••••">
        </div>
        <div class=" mb-3">
            <label for="verifyPassword" class="form-label">Vérifier le mot de passe</label>
            <input type="password" class="form-control" id="verifyPassword" name="verifyPassword"
                placeholder="••••••••">
        </div>
        <button type="submit" class="btn btn-primary">Envoyer</button>
    </form>
    <p>Déjà un compte? <a class="link-primary link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover"
            href="?action=login">Se connecter</a>
</body>