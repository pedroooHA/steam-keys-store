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
            /* ESTILOS CONSISTENTES COM OS OUTROS CARDS */
            .page-container {
                max-width: 1400px;
                min-width: 1400px;
                margin: 0 auto;
                padding: 30px 20px;
            }

            .page-header {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-bottom: 40px;
                padding: 0 10px;
            }

            .page-header h1 {
                font-size: 2.2rem;
                font-weight: 700;
                color: #000000;
                letter-spacing: -0.5px;
                text-align: center;
                width: 100%;
            }

            .catalogo-wrapper {
                background: white;
                border-radius: 1.5rem;
                box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            }

            .game-card-custom {
                background: #ffffff;
                border-radius: 16px;
                box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
                border: 1px solid #f0f0f0;
                transition: all 0.3s ease;
                overflow: hidden;
                display: flex;
                flex-direction: column;
                height: 100%;
            }

            .game-card-custom:hover {
                transform: translateY(-5px);
                box-shadow: 0 12px 35px rgba(0, 0, 0, 0.15);
            }

            .card-header-custom {
                position: relative;
                overflow: hidden;
                height: 180px;
                background: #f8f8f8;
            }

            .card-img-custom {
                width: 100%;
                height: 100%;
                object-fit: cover;
                transition: transform 0.3s ease;
            }

            .game-card-custom:hover .card-img-custom {
                transform: scale(1.08);
            }

            .steam-badge-custom {
                position: absolute;
                top: 12px;
                left: 12px;
                background: linear-gradient(135deg, #1b2838, #2a475e);
                color: #ffffff;
                padding: 6px 10px;
                border-radius: 8px;
                font-size: 0.75rem;
                font-weight: 600;
                display: flex;
                align-items: center;
                gap: 5px;
                box-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
            }

            .card-content-custom {
                padding: 20px;
                flex: 1;
                display: flex;
                flex-direction: column;
                gap: 15px;
                background: #ffffff !important;
            }

            .game-title-custom {
                font-size: 1.1rem;
                font-weight: 700;
                color: #000000;
                line-height: 1.3;
                margin: 0;
                min-height: 2.8em;
                display: -webkit-box;
                -webkit-line-clamp: 2;
                -webkit-box-orient: vertical;
                overflow: hidden;
                transition: color 0.2s ease;
            }

            .game-title-custom:hover {
                color: #333333;
            }

            .price-section-custom {
                margin-top: auto;
            }

            .pricing-simple-custom {
                margin-bottom: 15px;
            }

            .final-price-custom {
                font-size: 1.3rem;
                font-weight: 700;
                color: #000000ff;
                display: block;
            }

            .buttons-container {
                margin-top: auto;
            }

            .cart-form-custom {
                margin: 0;
            }

            .add-to-cart-btn-custom {
                background: linear-gradient(135deg, #000000, #333333);
                color: white;
                border: none;
                border-radius: 10px;
                padding: 12px;
                font-size: 0.95rem;
                font-weight: 600;
                cursor: pointer;
                transition: all 0.3s ease;
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 8px;
                text-decoration: none;
                width: 100%;
            }

            .add-to-cart-btn-custom:hover {
                background: linear-gradient(135deg, #333333, #555555);
                transform: translateY(-2px);
                color: white;
            }

            .remove-btn-custom {
                background: transparent;
                color: #e74c3c;
                border: 2px solid #e74c3c;
                border-radius: 10px;
                padding: 10px;
                font-size: 0.95rem;
                font-weight: 600;
                cursor: pointer;
                transition: all 0.3s ease;
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 8px;
                text-decoration: none;
                width: 100%;
            }

            .remove-btn-custom:hover {
                background: #e74c3c;
                color: white;
                transform: translateY(-2px);
            }

            .empty-state {
                text-align: center;
                padding: 80px 20px;
                color: #86868b;
                background: #ffffff;
                border-radius: 20px;
                box-shadow: 0 2px 15px rgba(0, 0, 0, 0.06);
            }

            .empty-state i {
                font-size: 4rem;
                margin-bottom: 20px;
                color: #e0e0e0;
            }

            .empty-state h3 {
                font-size: 1.5rem;
                margin-bottom: 10px;
                color: #000000;
                font-weight: 600;
            }

            .empty-state p {
                font-size: 1.1rem;
                color: #86868b;
            }

            .wishlist-count {
                background: #000000;
                color: white;
                padding: 0.25rem 0.75rem;
                border-radius: 20px;
                font-weight: bold;
                margin-left: 10px;
            }

            /* Melhorias para responsividade */
            @media (max-width: 768px) {
                .page-container {
                    padding: 20px 15px;
                }
                
                .page-header h1 {
                    font-size: 1.8rem;
                }
                
                .catalogo-wrapper {
                    padding: 1.5rem !important;
                }
                
                .game-title-custom {
                    font-size: 1rem;
                }
                
                .final-price-custom {
                    font-size: 1.1rem;
                }
                
                .add-to-cart-btn-custom,
                .remove-btn-custom {
                    font-size: 0.9rem;
                    padding: 10px;
                }
            }

            @media (max-width: 480px) {
                .card-content-custom {
                    padding: 15px;
                }

                .game-title-custom {
                    font-size: 1rem;
                }

                .final-price-custom {
                    font-size: 1.1rem;
                }
            }
            </style>
        </head>
        <body>
            <?php 
            $header_path = __DIR__ . '/../views/layout/header.php';
            if (file_exists($header_path)) {
                require $header_path;
            }
            ?>

            <div class="page-container">
                <div class="page-header">
                    <h1>
                        <i class=""></i>Minha Lista de Desejos
                        <span class="wishlist-count"><?php echo count($jogos); ?></span>
                    </h1>
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
                    <div class="empty-state">
                        <i class="fas fa-heart-broken"></i>
                        <h3>Sua lista de desejos está vazia</h3>
                        <p>Adicione jogos que você deseja comprar no futuro!</p>
                        <a href="index.php" class="btn btn-primary mt-3">
                            <i class="fas fa-gamepad me-2"></i>Explorar Jogos
                        </a>
                    </div>
                <?php else: ?>
                    <div class="catalogo-wrapper p-4 shadow-sm rounded-4">
                        <div class="row g-4">
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
                                <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                                    <div class="game-card-custom h-100 d-flex flex-column border-0 rounded-4 overflow-hidden">
                                        <a href="index.php?route=games&action=view&id=<?php echo $jogo['id']; ?>" class="text-decoration-none">
                                            <div class="card-header-custom position-relative p-0">
                                                <img src="<?php echo $imageUrl; ?>" alt="<?php echo htmlspecialchars($jogo['title']); ?>" class="card-img-custom w-100">
                                                <div class="steam-badge-custom">
                                                    <i class="fa-brands fa-steam"></i>
                                                    <span>Steam</span>
                                                </div>
                                            </div>
                                        </a>

                                        <div class="card-content-custom d-flex flex-column bg-white text-dark p-3">
                                            <a href="index.php?route=games&action=view&id=<?php echo $jogo['id']; ?>" class="text-decoration-none">
                                                <h5 class="game-title-custom fw-bold mb-2"><?php echo htmlspecialchars($jogo['title']); ?></h5>
                                            </a>
                                            
                                            <div class="price-section-custom mb-3">
                                                <div class="pricing-simple-custom">
                                                    <span class="final-price-custom">R$ <?php echo number_format($jogo['price'], 2, ',', '.'); ?></span>
                                                </div>
                                            </div>

                                            <div class="buttons-container d-flex flex-column gap-2">
                                                <form action="index.php?route=cart&action=add" method="post" class="cart-form-custom">
                                                    <input type="hidden" name="game_id" value="<?php echo $jogo['id']; ?>">
                                                    <button type="submit" class="add-to-cart-btn-custom w-100 fw-semibold">
                                                        <i class="fas fa-shopping-cart"></i>
                                                        Adicionar ao Carrinho
                                                    </button>
                                                </form>
                                                
                                                <form action="index.php?route=wishlist&action=remove&id=<?php echo $jogo['id']; ?>" method="post" class="remove-form-custom">
                                                    <button type="submit" class="remove-btn-custom w-100 fw-semibold">
                                                        <i class="fas fa-trash"></i>
                                                        Remover
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <?php 
            $footer_path = __DIR__ . '/../views/layout/footer.php';
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