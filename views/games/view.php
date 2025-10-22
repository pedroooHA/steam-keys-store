<?php require __DIR__ . '/../layout/header.php'; ?>

<div class="container py-4">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php" class="text-decoration-none">Início</a></li>
            <li class="breadcrumb-item"><a href="index.php?route=games&action=list" class="text-decoration-none">Jogos</a></li>
            <li class="breadcrumb-item active" aria-current="page"><?php echo htmlentities($game['title']); ?></li>
        </ol>
    </nav>

    <div class="row">
        <!-- Coluna da Imagem -->
        <div class="col-lg-6 mb-4">
            <?php
            $imagePath = htmlspecialchars($game['image'] ?? '');
            if (filter_var($imagePath, FILTER_VALIDATE_URL)) {
                $imageUrl = $imagePath;
            } else if (!empty($imagePath)) {
                $imageUrl = 'uploads/' . $imagePath;
            } else {
                $imageUrl = 'https://via.placeholder.com/600x400/1f2b57/a3b6e6?text=Imagem+Indisponível';
            }
            ?>
            
            <div class="game-image-container">
                <img src="<?php echo $imageUrl; ?>" 
                     alt="<?php echo htmlentities($game['title']); ?>" 
                     class="game-main-image img-fluid rounded-3"
                     id="mainImage">
                
                <!-- Badge Steam -->
                <div class="steam-badge">
                    <i class="fa-brands fa-steam me-1"></i> Disponível na Steam
                </div>
                
                <?php if (isset($game['discount']) && $game['discount'] > 0): ?>
                <div class="discount-badge">
                    -<?php echo $game['discount']; ?>%
                </div>
                <?php endif; ?>
            </div>

            <!-- Miniaturas (opcional, se tiver mais imagens) -->
            <div class="image-thumbnails mt-3">
                <div class="row g-2">
                    <div class="col-3">
                        <img src="<?php echo $imageUrl; ?>" 
                             class="img-thumbnail thumbnail-active" 
                             onclick="changeImage(this.src)">
                    </div>
                    <!-- Adicione mais miniaturas se disponível -->
                </div>
            </div>
        </div>

        <!-- Coluna das Informações -->
        <div class="col-lg-6">
            <div class="game-details">
                <h1 class="game-title mb-3"><?php echo htmlentities($game['title']); ?></h1>
                
                <!-- Avaliação -->
                <div class="rating-section mb-3">
                    <div class="stars mb-2">
                        <?php
                        $rating = $game['rating'] ?? 4.5;
                        $fullStars = floor($rating);
                        $hasHalfStar = ($rating - $fullStars) >= 0.5;
                        
                        for ($i = 1; $i <= 5; $i++):
                            if ($i <= $fullStars): ?>
                                <i class="fas fa-star text-warning"></i>
                            <?php elseif ($i == $fullStars + 1 && $hasHalfStar): ?>
                                <i class="fas fa-star-half-alt text-warning"></i>
                            <?php else: ?>
                                <i class="far fa-star text-warning"></i>
                            <?php endif;
                        endfor; ?>
                        <span class="rating-value ms-2"><?php echo number_format($rating, 1); ?></span>
                    </div>
                    <small class="text-muted">(<?php echo $game['review_count'] ?? '125'; ?> avaliações)</small>
                </div>

                <!-- Preço -->
                <div class="pricing-section mb-4">
                    <?php if (isset($game['original_price']) && $game['original_price'] > $game['price']): ?>
                        <div class="original-price text-muted text-decoration-line-through mb-1">
                            R$ <?php echo number_format($game['original_price'], 2, ',', '.'); ?>
                        </div>
                    <?php endif; ?>
                    
                    <div class="current-price mb-2">
                        <span class="price-amount" style="color: var(--cor-desconto); font-size: 2rem; font-weight: bold;">
                            R$ <?php echo number_format($game['price'], 2, ',', '.'); ?>
                        </span>
                        
                        <?php if (isset($game['discount']) && $game['discount'] > 0): ?>
                            <span class="discount-text text-success ms-2">
                                Economize <?php echo $game['discount']; ?>%
                            </span>
                        <?php endif; ?>
                    </div>
                    
                    <div class="installment-option text-muted">
                        ou 12x de R$ <?php echo number_format($game['price'] / 12, 2, ',', '.'); ?> sem juros
                    </div>
                </div>

                <!-- Ações -->
                <div class="action-buttons mb-4">
                    <form action="index.php?route=cart&action=add" method="post" class="d-grid gap-2">
                        <input type="hidden" name="game_id" value="<?php echo $game['id']; ?>">
                        
                        <button type="submit" class="btn btn-primary btn-lg py-3">
                            <i class="fas fa-shopping-cart me-2"></i>
                            Adicionar ao Carrinho - R$ <?php echo number_format($game['price'], 2, ',', '.'); ?>
                        </button>
                        
                        <button type="button" class="btn btn-outline-secondary">
                            <i class="fas fa-heart me-2"></i>
                            Adicionar à Lista de Desejos
                        </button>
                    </form>
                </div>

                <!-- Informações Rápidas -->
                <div class="quick-info mb-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="info-item">
                                <i class="fas fa-tag me-2 text-muted"></i>
                                <strong>Categoria:</strong> 
                                <?php echo htmlentities($game['category_name'] ?? '—'); ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-item">
                                <i class="fas fa-download me-2 text-muted"></i>
                                <strong>Plataforma:</strong> Steam
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-item">
                                <i class="fas fa-key me-2 text-muted"></i>
                                <strong>Chave Steam:</strong> 
                                <span class="text-success">Disponível</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-item">
                                <i class="fas fa-shield-alt me-2 text-muted"></i>
                                <strong>Garantia:</strong> 100% Original
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Entrega Instantânea -->
                <div class="delivery-info alert alert-success">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-bolt me-3 fs-4"></i>
                        <div>
                            <strong class="d-block">Entrega Instantânea</strong>
                            <small class="d-block">Chave Steam enviada automaticamente após a confirmação do pagamento</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Abas de Detalhes -->
    <div class="row mt-5">
        <div class="col-12">
            <div class="game-tabs">
                <ul class="nav nav-tabs" id="gameTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="description-tab" data-bs-toggle="tab" data-bs-target="#description" type="button" role="tab">
                            <i class="fas fa-file-alt me-2"></i>Descrição
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="specs-tab" data-bs-toggle="tab" data-bs-target="#specs" type="button" role="tab">
                            <i class="fas fa-cog me-2"></i>Especificações
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="reviews-tab" data-bs-toggle="tab" data-bs-target="#reviews" type="button" role="tab">
                            <i class="fas fa-star me-2"></i>Avaliações
                        </button>
                    </li>
                </ul>
                
                <div class="tab-content p-4 border border-top-0 rounded-bottom" style="background: var(--cor-card);">
                    <!-- Descrição -->
                    <div class="tab-pane fade show active" id="description" role="tabpanel">
                        <h4 class="mb-3">Sobre o Jogo</h4>
                        <div class="game-description">
                            <?php echo nl2br(htmlentities($game['description'])); ?>
                        </div>
                        
                        <!-- Características -->
                        <div class="features mt-4">
                            <div class="row">
                                <div class="col-md-6">
                                    <ul class="list-unstyled">
                                        <li class="mb-2"><i class="fas fa-check text-success me-2"></i> Mundo aberto expansivo</li>
                                        <li class="mb-2"><i class="fas fa-check text-success me-2"></i> Gráficos de última geração</li>
                                        <li class="mb-2"><i class="fas fa-check text-success me-2"></i> Multiplayer online</li>
                                    </ul>
                                </div>
                                <div class="col-md-6">
                                    <ul class="list-unstyled">
                                        <li class="mb-2"><i class="fas fa-check text-success me-2"></i> Suporte a mods</li>
                                        <li class="mb-2"><i class="fas fa-check text-success me-2"></i> Atualizações regulares</li>
                                        <li class="mb-2"><i class="fas fa-check text-success me-2"></i> Suporte em Português</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Especificações -->
                    <div class="tab-pane fade" id="specs" role="tabpanel">
                        <h4 class="mb-3">Requisitos do Sistema</h4>
                        <div class="row">
                            <div class="col-md-6">
                                <h5 class="text-success"><i class="fas fa-desktop me-2"></i>Mínimos</h5>
                                <ul class="list-unstyled">
                                    <li><strong>SO:</strong> Windows 10</li>
                                    <li><strong>Processador:</strong> Intel Core i5</li>
                                    <li><strong>Memória:</strong> 8 GB RAM</li>
                                    <li><strong>Placa de vídeo:</strong> GTX 1060</li>
                                    <li><strong>Armazenamento:</strong> 50 GB</li>
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <h5 class="text-primary"><i class="fas fa-rocket me-2"></i>Recomendados</h5>
                                <ul class="list-unstyled">
                                    <li><strong>SO:</strong> Windows 11</li>
                                    <li><strong>Processador:</strong> Intel Core i7</li>
                                    <li><strong>Memória:</strong> 16 GB RAM</li>
                                    <li><strong>Placa de vídeo:</strong> RTX 3060</li>
                                    <li><strong>Armazenamento:</strong> 50 GB SSD</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Avaliações -->
                    <div class="tab-pane fade" id="reviews" role="tabpanel">
                        <h4 class="mb-3">Avaliações dos Clientes</h4>
                        <div class="reviews-summary mb-4">
                            <div class="row align-items-center">
                                <div class="col-md-3 text-center">
                                    <div class="overall-rating">
                                        <div class="rating-number" style="font-size: 3rem; font-weight: bold; color: var(--cor-desconto);">
                                            <?php echo number_format($rating, 1); ?>
                                        </div>
                                        <div class="stars">
                                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                                <i class="fas fa-star <?php echo $i <= $rating ? 'text-warning' : 'text-muted'; ?>"></i>
                                            <?php endfor; ?>
                                        </div>
                                        <small class="text-muted">Baseado em <?php echo $game['review_count'] ?? '125'; ?> avaliações</small>
                                    </div>
                                </div>
                                <div class="col-md-9">
                                    <!-- Aqui você pode adicionar gráfico de distribuição de estrelas -->
                                    <p>As avaliações dos clientes serão exibidas aqui.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Jogos Relacionados -->
    <div class="row mt-5">
        <div class="col-12">
            <h3 class="mb-4">Jogos Relacionados</h3>
            <div class="row" id="relatedGames">
                <!-- Aqui você pode carregar jogos da mesma categoria -->
                <div class="col-12 text-center py-4">
                    <p class="text-muted">Carregando jogos relacionados...</p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.game-image-container {
    position: relative;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 8px 24px rgba(0,0,0,0.15);
}

.game-main-image {
    width: 100%;
    height: 400px;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.game-image-container:hover .game-main-image {
    transform: scale(1.02);
}

.steam-badge {
    position: absolute;
    top: 15px;
    left: 15px;
    background: linear-gradient(135deg, #1b2838, #2a475e);
    color: white;
    padding: 8px 16px;
    border-radius: 20px;
    font-size: 0.9rem;
    font-weight: 600;
    box-shadow: 0 4px 12px rgba(0,0,0,0.3);
}

.discount-badge {
    position: absolute;
    top: 15px;
    right: 15px;
    background: #e74c3c;
    color: white;
    padding: 8px 12px;
    border-radius: 6px;
    font-weight: bold;
    font-size: 1rem;
}

.image-thumbnails .img-thumbnail {
    cursor: pointer;
    transition: all 0.3s ease;
    height: 80px;
    object-fit: cover;
}

.image-thumbnails .img-thumbnail:hover,
.thumbnail-active {
    border-color: var(--cor-botao) !important;
    transform: scale(1.05);
}

.game-title {
    color: var(--cor-texto-principal);
    font-weight: 700;
    font-size: 2.2rem;
    line-height: 1.2;
    padding: 0px;
}

.rating-section .stars {
    font-size: 1.1rem;
}

.rating-value {
    font-weight: 600;
    color: var(--cor-texto-principal);
}

.quick-info .info-item {
    padding: 8px 0;
    border-bottom: 1px solid #f1f3f4;
}

.delivery-info {
    border: none;
    border-radius: 10px;
    background: linear-gradient(135deg, #d4edda, #c3e6cb);
}

.game-tabs .nav-tabs .nav-link {
    color: var(--cor-texto-principal);
    border: none;
    padding: 1rem 1.5rem;
    font-weight: 500;
}

.game-tabs .nav-tabs .nav-link.active {
    background: var(--cor-card);
    border-bottom: 3px solid var(--cor-botao);
    color: var(--cor-botao);
}

.game-description {
    line-height: 1.8;
    font-size: 1.1rem;
    color: var(--cor-texto-principal);
}

.features li {
    padding: 4px 0;
}

.overall-rating {
    padding: 1rem;
}

/* Responsividade */
@media (max-width: 768px) {
    .game-title {
        font-size: 1.8rem;
    }
    
    .price-amount {
        font-size: 1.5rem !important;
    }
    
    .game-main-image {
        height: 300px;
    }
}
</style>

<script>
function changeImage(src) {
    document.getElementById('mainImage').src = src;
    
    // Atualiza a classe ativa nas miniaturas
    document.querySelectorAll('.image-thumbnails .img-thumbnail').forEach(thumb => {
        thumb.classList.remove('thumbnail-active');
    });
    event.target.classList.add('thumbnail-active');
}

// Simular carregamento de jogos relacionados
document.addEventListener('DOMContentLoaded', function() {
    setTimeout(() => {
        document.getElementById('relatedGames').innerHTML = `
            <div class="col-12 text-center py-4">
                <p class="text-muted">Sistema de jogos relacionados será implementado em breve.</p>
            </div>
        `;
    }, 1000);
    
    // Efeito de loading no botão de compra
    document.querySelector('form button[type="submit"]').addEventListener('click', function() {
        const originalText = this.innerHTML;
        this.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Adicionando...';
        this.disabled = true;
        
        setTimeout(() => {
            this.innerHTML = originalText;
            this.disabled = false;
        }, 2000);
    });
});
</script>

<?php require __DIR__ . '/../layout/footer.php'; ?>