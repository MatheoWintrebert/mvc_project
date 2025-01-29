<?php declare(strict_types=1); ?>

<div class="container">
  <?php
  flash(name: 'changePassword');
  ?>
  <form id="changePasswordForm" name="changePasswordForm" method="post" action="./?action=changePassword">
    <input type="hidden" name="type" value="changePassword">
    <div class="mb-3">
      <label for="current-password" class="form-label">Mot de passe actuel:</label>
      <div class="input-group">
        <input type="password" id="current-password" name="current-password" class="form-control"
          placeholder="••••••••" />
        <button type="button" class="btn btn-outline-secondary">Show</button>
      </div>
    </div>
    <div class="mb-3">
      <label for="current-password" class="form-label">Nouveau mot de passe:</label>
      <div class="input-group">
        <input type="password" id="new-password" name="new-password" class="form-control" placeholder="••••••••" />
        <button type="button" class="btn btn-outline-secondary">Show</button>
      </div>
    </div>
    <div class="mb-3">
      <label for="current-password" class="form-label">Confirmation nouveau de passe:</label>
      <div class="input-group">
        <input type="password" id="conf-new-password" name="conf-new-password" class="form-control"
          placeholder="••••••••" />
        <button type="button" class="btn btn-outline-secondary">Show</button>
      </div>
    </div>
    <button type="submit" class="btn btn-primary" name="submit">Valider</button>
  </form>
</div>