<?php declare(strict_types=1); ?>

<body>
    <section class="vh-100" style="background-color:rgb(88, 89, 90);">
        <div class="container h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="card" style="width: 18rem;">
                    <div class="card-body">
                        <?php
                        flash(name: 'register');
                        ?>
                        <form id="registerForm" name="registerForm" method="post" action="./?action=register">
                            <input type="hidden" name="type" value="register">
                            <div class="mb-3">
                                <label for="email" class="form-label">Adresse mail</label>
                                <input type="email" class="form-control" id="email" name="email"
                                    placeholder="exemple@email.com">
                            </div>
                            <div class=" mb-3">
                                <label for="password" class="form-label">Mot de passe</label>
                                <input type="password" class="form-control" id="password" name="password"
                                    placeholder="••••••••">
                            </div>
                            <div class=" mb-3">
                                <label for="verifyPassword" class="form-label">Vérifier le mot de passe</label>
                                <input type="password" class="form-control" id="verifyPassword" name="verifyPassword"
                                    placeholder="••••••••">
                            </div>
                            <button type="submit" class="btn btn-primary" name="submit">Envoyer</button>
                        </form>
                        <p>Déjà un compte?
                            <a class="link-primary link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover"
                                href="?action=login">Se connecter
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>