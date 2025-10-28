<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Steam Keys Store</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
   
</head>
<body>
    <nav class="navbar navbar-expand-lg custom-header">
        <div class="container-fluid">
            <a class="navbar-brand logo" href="index.php">
                <i class="fas fa-gem"></i>
                BlackLabel Store
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="mainNav">
                <ul class="navbar-nav ms-auto">
        <?php if(!empty($_SESSION['user_id'])): 
            $me = User::findById($_SESSION['user_id']);
        ?>
          <li class="nav-item"><a class="nav-link" href="index.php?route=games">Categorias</a></li>
          <li class="nav-item"><a class="nav-link" href="index.php?route=games">Lista de desejos</a></li>
          <li class="nav-item"><a class="nav-link" href="index.php?route=logout">Sair</a></li>
        <?php else: ?>
          <li class="nav-item"><a class="nav-link" href="index.php?route=login">Login</a></li>
          <li class="nav-item"><a class="nav-link" href="index.php?route=register">Cadastrar</a></li>
        <?php endif; ?>
      </ul>

                <!-- Caixa de busca -->
                <form class="search-form" role="search" action="index.php?route=search" method="GET">
                    <span class="search-icon"><i class="fas fa-search"></i></span>
                    <input class="form-control" type="search" name="q" placeholder="Buscar jogos..." aria-label="Search">
                    <button class="btn" type="submit"><i class="fas fa-arrow-right"></i></button>
                </form>
                
                <!-- Ícone do carrinho -->
                <a href="index.php?route=cart" class="cart-btn">
                    <i class="fas fa-shopping-cart"></i>
                    <span>Carrinho</span>
                </a>
            </div>
        </div>
    </nav>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

 <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
        }

        body {
            background-color: #fefefe;
            color: #1d1d1f;
            line-height: 1.4;
        }

        .custom-header {
            background: #ffffff;
            border-bottom: 1px solid #e0e0e0;
            padding: 0;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .container-fluid {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .navbar-brand.logo {
            font-size: 1.4rem;
            font-weight: 600;
            color: #000000;
            letter-spacing: -0.3px;
            padding: 16px 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .navbar-brand.logo i {
            font-size: 1.6rem;
            color: #000000;
        }

        .navbar-nav .nav-link {
            color: #1d1d1f !important;
            font-weight: 500;
            padding: 12px 16px !important;
            border-radius: 8px;
            margin: 0 4px;
            transition: all 0.2s ease;
            font-size: 0.95rem;
        }

        .navbar-nav .nav-link:hover {
            background: #f5f5f7;
            color: #000000 !important;
        }

        .search-form {
            position: relative;
            margin: 0 15px;
        }

        .search-form .form-control {
            padding: 10px 16px 10px 40px;
            background: #fafafa;
            border: 1px solid #e0e0e0;
            border-radius: 10px;
            font-size: 0.9rem;
            color: #1d1d1f;
            transition: all 0.2s ease;
            outline: none;
            width: 280px;
        }

        .search-form .form-control:focus {
            border-color: #000000;
            background: #ffffff;
            box-shadow: 0 0 0 3px rgba(0, 0, 0, 0.05);
        }

        .search-form .search-icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #666666;
            font-size: 0.95rem;
        }

        .search-form .btn {
            position: absolute;
            right: 4px;
            top: 50%;
            transform: translateY(-50%);
            background: transparent;
            border: none;
            color: #666666;
            padding: 6px 10px;
            border-radius: 6px;
            transition: all 0.2s ease;
        }

        .search-form .btn:hover {
            background: #f0f0f0;
            color: #000000;
        }

        .cart-btn {
            background: #000000 !important;
            color: white !important;
            border: none;
            border-radius: 10px;
            padding: 10px 14px !important;
            font-size: 0.9rem;
            font-weight: 500;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            gap: 6px;
            text-decoration: none;
        }

        .cart-btn:hover {
            background: #333333 !important;
            color: white !important;
            transform: translateY(-1px);
        }

        .navbar-toggler {
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 8px 10px;
        }

        .navbar-toggler:focus {
            box-shadow: 0 0 0 2px rgba(0, 0, 0, 0.1);
        }

        .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba%280, 0, 0, 0.8%29' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
        }

        .fas.fa-gem {
            font-family: 'Font Awesome 5 Free';
            padding-top: 20px;
}

        @media (max-width: 991px) {
            .search-form {
                margin: 10px 0;
                width: 100%;
            }
            
            .search-form .form-control {
                width: 100%;
            }
            
            .navbar-nav .nav-link {
                margin: 2px 0;
            }
            
            .cart-btn {
                margin: 10px 0;
                justify-content: center;
            }
        }

        @media (max-width: 768px) {
            .container-fluid {
                padding: 0 15px;
            }
            
            .navbar-brand.logo {
                font-size: 1.3rem;
            }
        }
    </style>