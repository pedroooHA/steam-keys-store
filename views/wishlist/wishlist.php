<?php
session_start();
require_once 'models/WishlistModel.php';
require_once 'models/User.php';
require_once 'models/Database.php';

// Confere login
if (empty($_SESSION['user_id'])) {
    header("Location: index.php?route=login");
    exit;
}

$wishlistModel = new WishlistModel();
$wishlist = $wishlistModel->listarPorUsuario($_SESSION['user_id']);
?>

<?php include 'header.php'; ?>

<div class="page-container">
    <div class="page-header">
        <h1>Minha Lista de Desejos</h1>
    </div>

    <?php if (empty($wishlist)): ?>
        <div class="empty-state">
            <i class="fas fa-heart"></i>
            <h3>Lista de desejos vazia</h3>
            <p>Você ainda não adicionou nenhum jogo à sua lista de desejos.</p>
        </div>
    <?php else: ?>
        <div class="catalogo-wrapper p-4 shadow-sm rounded-4">
            <div class="row g-4">
                <?php foreach ($wishlist as $jogo): ?>
                    <?php
                    // Lógica da imagem
                    $imagePath = htmlspecialchars($jogo['imagem'] ?? '');
                    if (filter_var($imagePath, FILTER_VALIDATE_URL)) {
                        $imageUrl = $imagePath;
                    } else if (!empty($imagePath)) {
                        $imageUrl = 'uploads/'. $imagePath;
                    } else {
                        $imageUrl = 'https://via.placeholder.com/300x180/1f2b57/a3b6e6?text=Sem+Imagem';
                    }
                    ?>
                    
                    <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                        <div class="game-card-custom h-100 d-flex flex-column border-0 rounded-4 overflow-hidden">
                            <a href="index.php?route=games&action=view&id=<?php echo $jogo['id']; ?>" class="text-decoration-none">
                                <div class="card-header-custom position-relative p-0">
                                    <img src="<?php echo $imageUrl; ?>" alt="<?php echo htmlspecialchars($jogo['titulo']); ?>" class="card-img-custom w-100">
                                    <div class="steam-badge-custom">
                                        <i class="fa-brands fa-steam"></i>
                                        <span>Steam</span>
                                    </div>
                                </div>
                            </a>

                            <div class="card-content-custom d-flex flex-column bg-white text-dark p-3">
                                <a href="index.php?route=games&action=view&id=<?php echo $jogo['id']; ?>" class="text-decoration-none">
                                    <h5 class="game-title-custom fw-bold mb-2"><?php echo htmlspecialchars($jogo['titulo']); ?></h5>
                                </a>
                                
                                <div class="price-section-custom mb-3">
                                    <div class="pricing-simple-custom">
                                        <span class="final-price-custom">R$ <?php echo number_format($jogo['preco'], 2, ',', '.'); ?></span>
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
                                    
                                    <a href="index.php?route=wishlist_remove&id=<?php echo $jogo['id']; ?>" class="remove-btn-custom w-100 fw-semibold text-center">
                                        <i class="fas fa-trash"></i>
                                        Remover
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>
</div>

<style>
.page-container {
    max-width: 1400px;
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

/* ESTILOS DOS CARDS IGUAIS AOS OUTROS */
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
    color: #27ae60;
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
    .carousel-slide {
        flex: 0 0 240px;
        min-width: 240px;
    }

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

<?php include 'footer.php'; ?>