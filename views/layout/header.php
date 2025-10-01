<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($pageTitle) ? $pageTitle : 'Steam Keys Store'; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
  <div class="container-fluid">
    <a class="navbar-brand logo" href="index.php">Steam Keys Store</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="mainNav">
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
      <!-- Caixa de busca -->
      <form class="d-flex ms-3" role="search" action="index.php?route=search" method="GET">
        <input class="form-control me-2" type="search" name="q" placeholder="Buscar jogos..." aria-label="Search">
        <button class="btn btn-outline-light" type="submit"><i class="fas fa-search"></i></button>
      </form>
      <!-- Ícone do carrinho -->
      <a href="index.php?route=cart" class="btn btn-outline-light ms-3"><i class="fas fa-shopping-cart"></i></a>
    </div>
  </div>
</nav>