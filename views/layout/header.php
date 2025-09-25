<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Steam Keys Store</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
  <div class="container">
    <a class="navbar-brand" href="index.php">Steam Keys Store</a>
    <div class="collapse navbar-collapse">
      <ul class="navbar-nav ms-auto">
        <?php if(!empty($_SESSION['user_id'])): 
            $me = User::findById($_SESSION['user_id']);
        ?>
        <li class="nav-item"><a class="nav-link" href="index.php?route=games">Jogos</a></li>
        <li class="nav-item"><a class="nav-link" href="index.php?route=categories">Categorias</a></li>
        <li class="nav-item"><a class="nav-link" href="index.php?route=logout">Sair</a></li>
        <?php else: ?>
        <li class="nav-item"><a class="nav-link" href="index.php?route=login">Login</a></li>
        <li class="nav-item"><a class="nav-link" href="index.php?route=register">Cadastrar</a></li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>
<div class="container">
<?php if(!empty($_SESSION['flash'])): ?>
  <div class="alert alert-warning"><?php echo htmlentities($_SESSION['flash']); unset($_SESSION['flash']); ?></div>
<?php endif; ?>
