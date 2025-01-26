<!-- Il faut que j'injecte le JS pour que les buttons affichent en clair leur input password respectif lorsqu'on clique dessus -->

<div class="container">
  <form method="POST" action="./?action=changePassword">
    <?php echo isset($alert) && !empty($alert) ? '<div class="alert alert-danger" role="alert">'.$alert.'</div>' : ""; ?>
    <div class="mb-3">
      <label for="current-password" class="form-label">Mot de passe actuel:</label>
      <div class="input-group">
        <input type="password" id="current-password" name="current-password" class="form-control"/>
        <button type="button" class="btn btn-outline-secondary">Click me</button>
      </div>
    </div>
    <div class="mb-3">
      <label for="current-password" class="form-label">Nouveau mot de passe:</label>
      <div class="input-group">
        <input type="password" id="new-password" name="new-password" class="form-control"/>
        <button type="button" class="btn btn-outline-secondary">Click me</button>
      </div>
    </div>
    <div class="mb-3">
      <label for="current-password" class="form-label">Confirmation nouveau de passe:</label>
      <div class="input-group">
        <input type="password" id="conf-new-password" name="conf-new-password" class="form-control"/>
        <button type="button" class="btn btn-outline-secondary">Click me</button>
      </div>
    </div>
    <button type="submit" class="btn btn-primary">Valider</button>
  </form>
</div>
