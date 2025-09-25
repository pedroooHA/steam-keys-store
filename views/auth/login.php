<?php require __DIR__ . '/../layout/header.php'; ?>
<h2>Login</h2>
<form method="post" action="index.php?route=login">
  <div class="mb-3">
    <label>Email</label>
    <input class="form-control" type="email" name="email" required>
  </div>
  <div class="mb-3">
    <label>Senha</label>
    <input class="form-control" type="password" name="password" required>
  </div>
  <button class="btn btn-primary">Entrar</button>
</form>
<?php require __DIR__ . '/../layout/footer.php'; ?>