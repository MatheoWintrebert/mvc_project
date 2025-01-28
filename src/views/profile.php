<?php declare(strict_types=1); ?>

<div class="container-fluid">
  <div class="row">
    <div class="col-12 col-sm-7">
      <h1><?php echo $email; ?></h1>
      <h2>Nombre de parties gagnées: <?php echo $nbWonGames; ?></h2>
      <h2>Votre rang actuel : <?php echo $currentRank; ?></h2>
      <a href="./?action=changePassword" class="btn btn-info mt-3">Changer votre mot de passe</a>
      <a href="./?action=login" class="btn btn-warning mt-3">Se déconnecter</a>
    </div>
    <div class="col-12 col-sm-5">
      <div class="accordion" id="accordionGames">
        <?php for ($i = 1; $i < 6; $i++) { ?>
          <div class="accordion-item">
            <h2 class="accordion-header">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                data-bs-target="#collapse<?php echo $i; ?>" aria-expanded="false"
                aria-controls="collapse<?php echo $i; ?>">
                Partie n°<?php echo $i; ?>
              </button>
            </h2>
            <div id="collapse<?php echo $i; ?>" class="accordion-collapse collapse" data-bs-parent="#accordionGames">
              <div class="accordion-body">
                <strong>Lorem ipsum odor amet, consectetuer adipiscing elit.</strong>
                Turpis molestie luctus, orci nascetur maecenas ex.
                Cras blandit natoque tortor commodo, nec facilisis nisi sapien.
                Semper ultricies purus mus nunc sapien sociosqu justo.
                Scelerisque maximus congue ultrices libero sem fusce.
              </div>
            </div>
          </div>
        <?php }
        ; ?>
      </div>
    </div>
  </div>
</div>