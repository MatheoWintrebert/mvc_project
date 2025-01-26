<?php declare(strict_types=1); ?>

<body>
    <section class="vh-100" style="background-color:rgb(88, 89, 90);">
        <div class="container h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="card" style="width: 18rem;">
                    <div class="card-body">
                        <?php
                        flash(name: 'login');
                        ?>
                        <form id="loginForm" name="loginForm" method="post" action="./?action=login">
                            <input type="hidden" name="type" value="login">
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
                            <button type="submit" class="btn btn-primary" name="submit">Connexion</button>
                        </form>
                        <p>Vous n'avez pas de compte? <a href="?action=register">Créer un compte</a></p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>