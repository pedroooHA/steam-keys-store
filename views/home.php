<?php require __DIR__ . '/layout/header.php'; ?>

<section class="catalogo-home py-5">
    <div class="container">

        <div class="catalogo-wrapper p-4 shadow-sm rounded-4">
            <div class="row g-4">
                <?php foreach ($games as $game): ?>
                    <?php
                        $imagePath = htmlspecialchars($game['image'] ?? '');
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
                            <a href="index.php?route=games&action=view&id=<?php echo $game['id']; ?>" class="text-decoration-none">
                                <div class="card-header-custom position-relative p-0">
                                    <img src="<?php echo $imageUrl; ?>" alt="<?php echo htmlspecialchars($game['title']); ?>" class="card-img-custom w-100">
                                    <div class="steam-badge-custom">
                                        <i class="fa-brands fa-steam"></i>
                                        <span>Steam</span>
                                    </div>
                                </div>
                            </a>

                            <div class="card-content-custom d-flex flex-column bg-white text-dark p-3">
                                <h5 class="game-title-custom fw-bold mb-2"><?php echo htmlspecialchars($game['title']); ?></h5>
                                
                                <div class="price-section-custom mb-3">
                                    <div class="pricing-simple-custom">
                                        <span class="final-price-custom">R$ <?php echo number_format($game['price'], 2, ',', '.'); ?></span>
                                    </div>
                                </div>

                                <form action="index.php?route=cart&action=add" method="post" class="cart-form-custom mt-auto">
                                    <input type="hidden" name="game_id" value="<?php echo $game['id']; ?>">
                                    <button type="submit" class="add-to-cart-btn-custom w-100 fw-semibold">
                                        <i class="fas fa-shopping-cart"></i>
                                        Adicionar ao Carrinho
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>

<style>
.catalogo-home {
    background: #f8f9fa;
}

.section-title {
    font-size: 2.2rem;
    font-weight: 700;
    color: #1d1d1f;
    text-align: center;
    margin-bottom: 2rem !important;
}

.catalogo-wrapper {
    background: white;
    border-radius: 1.5rem;
    box-shadow: 0 4px 12px rgba(0,0,0,0.05);
}

/* ESTILOS DOS CARDS IGUAIS AO SEGUNDO CÓDIGO */
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

.cart-form-custom {
    margin-top: auto;
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
}

.add-to-cart-btn-custom:hover {
    background: linear-gradient(135deg, #333333, #555555);
    transform: translateY(-2px);
}

/* Melhorias para responsividade */
@media (max-width: 768px) {
    .section-title {
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
}
</style>

<?php require __DIR__ . '/layout/footer.php'; ?>