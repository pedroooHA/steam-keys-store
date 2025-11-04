<?php
class WishlistController {
    private $wishlistModel;

    public function __construct() {
        $this->wishlistModel = new WishlistModel();
    }

    public function add() {
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['error'] = 'Você precisa estar logado para adicionar à lista de desejos.';
            header('Location: index.php?route=login');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['game_id'])) {
            $jogo_id = (int)$_POST['game_id'];
            $usuario_id = $_SESSION['user_id'];

            if ($this->wishlistModel->verificarExistente($usuario_id, $jogo_id)) {
                $_SESSION['info'] = 'Este jogo já está na sua lista de desejos.';
            } else {
                if ($this->wishlistModel->adicionar($usuario_id, $jogo_id)) {
                    $_SESSION['success'] = 'Jogo adicionado à lista de desejos!';
                } else {
                    $_SESSION['error'] = 'Erro ao adicionar à lista de desejos.';
                }
            }

            header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? 'index.php'));
            exit;
        }
    }

    public function remove() {
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['error'] = 'Ação não permitida.';
            header('Location: index.php');
            exit;
        }

        $jogo_id = isset($_GET['id']) ? (int)$_GET['id'] : null;
        $usuario_id = $_SESSION['user_id'];

        if ($jogo_id && $this->wishlistModel->remover($usuario_id, $jogo_id)) {
            $_SESSION['success'] = 'Jogo removido da lista de desejos.';
        } else {
            $_SESSION['error'] = 'Erro ao remover da lista de desejos.';
        }

        header('Location: index.php?route=wishlist');
        exit;
    }

    public function show() {
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['error'] = 'Você precisa estar logado para ver sua lista de desejos.';
            header('Location: index.php?route=login');
            exit;
        }

        $jogos = $this->wishlistModel->listarPorUsuario($_SESSION['user_id']);
        
        // Carregar a view da lista de desejos
        $this->renderWishlist($jogos);
    }

    private function renderWishlist($jogos) {
        $base_dir = dirname(__DIR__);
        ?>
        <!DOCTYPE html>
        <html lang="pt-BR">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Lista de Desejos - Catálogo de Jogos</title>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
            <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
            <style>
            /* Estilos consistentes com a home */
            .game-card {
                transition: transform 0.3s ease, box-shadow 0.3s ease;
                border-radius: 12px;
                overflow: hidden;
                background: #fff;
                box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            }

            .game-card:hover {
                transform: translateY(-8px);
                box-shadow: 0 12px 24px rgba(0,0,0,0.15);
            }

            .card-img {
                transition: transform 0.5s ease;
                height: 200px;
                object-fit: cover;
                width: 100%;
            }

            .game-card:hover .card-img {
                transform: scale(1.05);
            }

            .steam-tag {
                position: absolute;
                top: 12px;
                right: 12px;
                background: linear-gradient(135deg, #1b2838, #2a475e);
                color: white;
                padding: 6px 12px;
                border-radius: 20px;
                font-size: 0.8rem;
                font-weight: bold;
                box-shadow: 0 2px 8px rgba(0,0,0,0.3);
            }

            .card-body.d-flex.flex-column {
                background-color: black;
                color: white;
            }

            h3.card-title {
                margin: 2%;
                font-family: Georgia, 'Times New Roman', Times, serif;
            }

            span.final-price {
                margin: 2%;
                color: #00ff88;
                font-weight: bold;
                font-size: 1.2rem;
            }

            .btn-primary {
                background-color: #000000;
                border-color: #000000;
                transition: all 0.3s ease;
            }

            .btn-primary:hover {
                background-color: white;
                color: black;
                transform: scale(1.05);
            }

            .btn-outline-danger {
                border-color: #dc3545;
                color: #dc3545;
                transition: all 0.3s ease;
            }

            .btn-outline-danger:hover {
                background-color: #dc3545;
                color: white;
                transform: scale(1.05);
            }

            .wishlist-header {
                background: #f8f9fa;
                padding: 2rem 0;
                border-bottom: 1px solid #dee2e6;
                margin-bottom: 2rem;
            }

            .wishlist-count {
                background: #000000;
                color: white;
                padding: 0.25rem 0.75rem;
                border-radius: 20px;
                font-weight: bold;
            }

            .empty-wishlist {
                text-align: center;
                padding: 4rem 2rem;
                color: #6c757d;
            }

            .empty-wishlist i {
                font-size: 4rem;
                margin-bottom: 1rem;
                color: #dee2e6;
            }

            .action-buttons {
                display: flex;
                gap: 0.5rem;
                margin-top: auto;
            }
            </style>
        </head>
        <body>
            <?php 
            $header_path = $base_dir . '/layout/header.php';
            if (file_exists($header_path)) {
                require $header_path;
            }
            ?>

            <div class="container mt-4">
                <div class="wishlist-header">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h1 class="h2 mb-1">
                                <i class="fas fa-heart text-danger me-2"></i>Minha Lista de Desejos
                                <span class="wishlist-count"><?php echo count($jogos); ?></span>
                            </h1>
                            <p class="text-muted mb-0">Seus jogos favoritos em um só lugar</p>
                        </div>
                        <div class="col-md-4 text-end">
                            <a href="index.php" class="btn btn-outline-primary">
                                <i class="fas fa-arrow-left me-2"></i>Voltar às Compras
                            </a>
                        </div>
                    </div>
                </div>

                <?php if (isset($_SESSION['success'])): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <?php if (isset($_SESSION['error'])): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <?php if (empty($jogos)): ?>
                    <div class="empty-wishlist">
                        <i class="fas fa-heart-broken"></i>
                        <h3 class="mb-3">Sua lista de desejos está vazia</h3>
                        <p class="text-muted mb-4">Adicione jogos que você deseja comprar no futuro!</p>
                        <a href="index.php" class="btn btn-primary btn-lg">
                            <i class="fas fa-gamepad me-2"></i>Explorar Jogos
                        </a>
                    </div>
                <?php else: ?>
                    <div class="row">
                        <?php foreach ($jogos as $jogo): ?>
                            <?php
                                $imagePath = htmlspecialchars($jogo['image'] ?? '');
                                if (filter_var($imagePath, FILTER_VALIDATE_URL)) {
                                    $imageUrl = $imagePath;
                                } else if (!empty($imagePath)) {
                                    $imageUrl = 'uploads/' . $imagePath;
                                } else {
                                    $imageUrl = 'https://via.placeholder.com/400x300/1f2b57/a3b6e6?text=Sem+Imagem';
                                }
                            ?>
                            <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
                                <div class="game-card h-100 d-flex flex-column">
                                    <a href="index.php?route=games&action=view&id=<?php echo $jogo['id']; ?>" class="card-link-header">
                                        <header class="card-header position-relative">
                                            <img src="<?php echo $imageUrl; ?>" alt="<?php echo htmlspecialchars($jogo['title']); ?>" class="card-img">
                                            <div class="steam-tag"><i class="fa-brands fa-steam"></i> Steam</div>
                                        </header>
                                    </a>
                                    <div class="card-body d-flex flex-column">
                                        <h3 class="card-title"><?php echo htmlspecialchars($jogo['title']); ?></h3>
                                        <div class="card-pricing-simple">
                                            <span class="final-price">R$ <?php echo number_format($jogo['price'], 2, ',', '.'); ?></span>
                                        </div>
                                        
                                        <div class="action-buttons">
                                            <form action="index.php?route=cart&action=add" method="post" class="w-100">
                                                <input type="hidden" name="game_id" value="<?php echo $jogo['id']; ?>">
                                                <button type="submit" class="btn btn-primary w-100 mb-2">
                                                    <i class="fas fa-shopping-cart me-2"></i>Adicionar ao Carrinho
                                                </button>
                                            </form>
                                            
                                            <form action="index.php?route=wishlist&action=remove&id=<?php echo $jogo['id']; ?>" method="post" class="w-100">
                                                <button type="submit" class="btn btn-outline-danger w-100">
                                                    <i class="fas fa-trash me-2"></i>Remover
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>

            <?php 
            $footer_path = $base_dir . '/layout/footer.php';
            if (file_exists($footer_path)) {
                require $footer_path;
            }
            ?>

            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        </body>
        </html>
        <?php
    }
}
?>