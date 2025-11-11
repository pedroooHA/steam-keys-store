<?php 
// Corrija o caminho do header
$baseDir = dirname(__DIR__);
require $baseDir . '/layout/header.php'; 
?>

<div class="page-container">
    <div class="page-header">
        <h1>Catálogo de Jogos</h1>
        <?php if (!empty($_SESSION['user_id']) && isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
            <a class="btn-primary" href="index.php?route=games&action=create">
                <i class="fas fa-plus"></i> Adicionar jogo
            </a>
        <?php endif; ?>
    </div>

    <?php if (!empty($groupedGames) && is_array($groupedGames)): ?>
        <?php foreach ($groupedGames as $categoryName => $gamesInCategory): ?>
            <section class="category-section">
                <div class="category-header">
                    <h2 class="category-title"><?php echo htmlentities($categoryName); ?></h2>
                    <div class="category-line"></div>
                </div>

                <div class="carousel-container">
                    <button class="carousel-btn carousel-btn-prev" aria-label="Jogos anteriores">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    
                    <div class="carousel-wrapper">
                        <div class="carousel-track">
                            <?php foreach ($gamesInCategory as $game): ?>
                                <?php
                                // Lógica da imagem
                                $imagePath = htmlspecialchars($game['image'] ?? '');
                                if (filter_var($imagePath, FILTER_VALIDATE_URL)) {
                                    $imageUrl = $imagePath;
                                } else if (!empty($imagePath)) {
                                    $imageUrl = 'uploads/'. $imagePath;
                                } else {
                                    $imageUrl = 'https://via.placeholder.com/300x180/1f2b57/a3b6e6?text=Sem+Imagem';
                                }
                                ?>
                                
                                <div class="carousel-slide">
                                    <div class="game-card">
                                        <!-- LINK ADICIONADO AQUI -->
                                        <a href="index.php?route=games&action=view&id=<?php echo $game['id']; ?>" class="text-decoration-none">
                                            <div class="card-image-container">
                                                <img src="<?php echo $imageUrl; ?>" alt="<?php echo htmlspecialchars($game['title']); ?>" class="card-image">
                                                <div class="steam-badge">
                                                    <i class="fab fa-steam"></i>
                                                    <span>Steam</span>
                                                </div>
                                            </div>
                                        </a>
                                        <!-- FIM DO LINK -->
                                        
                                        <div class="card-content">
                                            <!-- LINK ADICIONADO NO TÍTULO TAMBÉM -->
                                            <a href="index.php?route=games&action=view&id=<?php echo $game['id']; ?>" class="text-decoration-none">
                                                <h3 class="game-title"><?php echo htmlspecialchars($game['title']); ?></h3>
                                            </a>
                                            
                                            <div class="price-section">
                                                <?php if (isset($game['discount_percent']) && isset($game['final_price'])): ?>
                                                    <div class="pricing-with-discount">
                                                        <span class="discount-badge">-<?php echo htmlspecialchars($game['discount_percent']); ?>%</span>
                                                        <div class="price-column">
                                                            <span class="original-price">R$ <?php echo number_format($game['price'], 2, ',', '.'); ?></span>
                                                            <span class="final-price">R$ <?php echo number_format($game['final_price'], 2, ',', '.'); ?></span>
                                                        </div>
                                                    </div>
                                                <?php else: ?>
                                                    <div class="pricing-simple">
                                                        <span class="final-price">R$ <?php echo number_format($game['price'], 2, ',', '.'); ?></span>
                                                    </div>
                                                <?php endif; ?>
                                            </div>

                                            <form action="index.php?route=cart&action=add" method="post" class="cart-form">
                                                <input type="hidden" name="game_id" value="<?php echo $game['id']; ?>">
                                                <button type="submit" class="add-to-cart-btn">
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
                    
                    <button class="carousel-btn carousel-btn-next" aria-label="Próximos jogos">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </div>
            </section>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="empty-state">
            <i class="fas fa-gamepad"></i>
            <h3>Nenhum jogo encontrado</h3>
            <p>Não há jogos disponíveis no momento.</p>
        </div>
    <?php endif; ?>
</div>

<?php 
// Corrija também o caminho do footer
require $baseDir . '/layout/footer.php'; 
?>

<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
    }

    body {
        background-color: #f5f5f7;
        color: #1d1d1f;
        line-height: 1.4;
        min-height: 100vh;
    }

    h1 {
        text-align: center;
    }

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
    }

    .btn-primary {
        background: #000000;
        color: white;
        border: none;
        border-radius: 12px;
        padding: 14px 24px;
        font-size: 1rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-primary:hover {
        background: #333333;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    .category-section {
        margin-bottom: 50px;
        background: #ffffff;
        border-radius: 20px;
        padding: 30px;
        box-shadow: 0 2px 15px rgba(0, 0, 0, 0.06);
        border: 1px solid #f0f0f0;
    }

    .category-header {
        display: flex;
        align-items: center;
        gap: 20px;
        margin-bottom: 25px;
    }

    .category-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: #000000;
        white-space: nowrap;
        background: linear-gradient(135deg, #000000, #333333);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .category-line {
        flex: 1;
        height: 2px;
        background: linear-gradient(90deg, #e0e0e0, transparent);
    }

    /* CARROSSEL */
    .carousel-container {
        position: relative;
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .carousel-btn {
        background: #ffffff;
        border: 2px solid #f0f0f0;
        border-radius: 50%;
        width: 48px;
        height: 48px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
        flex-shrink: 0;
        z-index: 2;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .carousel-btn:hover {
        background: #000000;
        border-color: #000000;
        color: #ffffff;
        transform: scale(1.1);
    }

    .carousel-btn:disabled {
        opacity: 0.3;
        cursor: not-allowed;
        transform: none;
    }

    .carousel-btn:disabled:hover {
        background: #ffffff;
        border-color: #f0f0f0;
        color: inherit;
    }

    .carousel-wrapper {
        flex: 1;
        overflow: hidden;
        position: relative;
    }

    .carousel-track {
        display: flex;
        gap: 20px;
        transition: transform 0.5s ease;
        padding: 5px 0;
        cursor: grab;
        user-select: none;
        scroll-behavior: smooth;
        overflow-x: auto;
        scrollbar-width: thin;
        scrollbar-color: #c1c1c1 transparent;
    }

    .carousel-track::-webkit-scrollbar {
        height: 6px;
    }

    .carousel-track::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }

    .carousel-track::-webkit-scrollbar-thumb {
        background: #c1c1c1;
        border-radius: 10px;
    }

    .carousel-track::-webkit-scrollbar-thumb:hover {
        background: #a8a8a8;
    }

    .carousel-track:active {
        cursor: grabbing;
    }

    .carousel-slide {
        flex: 0 0 280px;
        min-width: 280px;
    }

    .game-card {
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

    .game-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 35px rgba(0, 0, 0, 0.15);
    }

    .card-image-container {
        position: relative;
        overflow: hidden;
        height: 180px;
        background: #f8f8f8;
    }

    .card-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .game-card:hover .card-image {
        transform: scale(1.08);
    }

    .steam-badge {
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

    .card-content {
        padding: 20px;
        flex: 1;
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    .game-title {
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

    .game-title:hover {
        color: #333333;
    }

    .price-section {
        margin-top: auto;
    }

    .pricing-with-discount {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
    }

    .discount-badge {
        background: linear-gradient(135deg, #e74c3c, #c0392b);
        color: #ffffff;
        padding: 5px 8px;
        border-radius: 6px;
        font-size: 0.8rem;
        font-weight: 700;
    }

    .price-column {
        display: flex;
        flex-direction: column;
        align-items: flex-end;
        gap: 2px;
    }

    .original-price {
        font-size: 0.85rem;
        color: #86868b;
        text-decoration: line-through;
        font-weight: 500;
    }

    .final-price {
        font-size: 1.2rem;
        font-weight: 700;
        color: #27ae60;
    }

    .pricing-simple {
        margin-bottom: 15px;
    }

    .pricing-simple .final-price {
        font-size: 1.3rem;
        font-weight: 700;
        color: #000000ff;
        display: block;
    }

    .cart-form {
        margin-top: auto;
    }

    .add-to-cart-btn {
        width: 100%;
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

    .add-to-cart-btn:hover {
        background: linear-gradient(135deg, #333333, #555555);
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

    @media (max-width: 768px) {
        .page-container {
            padding: 20px 15px;
        }

        .page-header {
            flex-direction: column;
            gap: 20px;
            align-items: flex-start;
            padding: 0;
        }

        .page-header h1 {
            font-size: 1.8rem;
        }

        .category-section {
            padding: 20px;
            margin-bottom: 30px;
        }

        .carousel-slide {
            flex: 0 0 260px;
            min-width: 260px;
        }

        .carousel-btn {
            width: 40px;
            height: 40px;
        }
    }

    @media (max-width: 480px) {
        .carousel-slide {
            flex: 0 0 240px;
            min-width: 240px;
        }

        .card-content {
            padding: 15px;
        }

        .game-title {
            font-size: 1rem;
        }

        .final-price {
            font-size: 1.1rem;
        }
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Inicializar todos os carrosseis
    document.querySelectorAll('.carousel-container').forEach(initCarousel);
    
    function initCarousel(container) {
        const track = container.querySelector('.carousel-track');
        const prevBtn = container.querySelector('.carousel-btn-prev');
        const nextBtn = container.querySelector('.carousel-btn-next');
        const slides = container.querySelectorAll('.carousel-slide');
        
        if (slides.length === 0) return;
        
        const slideWidth = slides[0].offsetWidth + 20; // width + gap
        const visibleSlides = Math.floor(track.offsetWidth / slideWidth);
        let currentPosition = 0;
        const maxPosition = Math.max(0, slides.length - visibleSlides);
        
        // Atualizar estado dos botões
        function updateButtons() {
            prevBtn.disabled = currentPosition === 0;
            nextBtn.disabled = currentPosition >= maxPosition;
        }
        
        // Navegação com botões
        nextBtn.addEventListener('click', () => {
            if (currentPosition < maxPosition) {
                currentPosition++;
                updateCarousel();
            }
        });
        
        prevBtn.addEventListener('click', () => {
            if (currentPosition > 0) {
                currentPosition--;
                updateCarousel();
            }
        });
        
        function updateCarousel() {
            track.style.transform = `translateX(-${currentPosition * slideWidth}px)`;
            updateButtons();
        }
        
        // Scroll suave com arrastar
        let isDragging = false;
        let startPosition = 0;
        let currentTranslate = 0;
        let prevTranslate = 0;
        
        track.addEventListener('mousedown', dragStart);
        track.addEventListener('touchstart', dragStart);
        track.addEventListener('mouseup', dragEnd);
        track.addEventListener('touchend', dragEnd);
        track.addEventListener('mousemove', drag);
        track.addEventListener('touchmove', drag);
        
        function dragStart(e) {
            if (e.type === 'touchstart') {
                startPosition = e.touches[0].clientX;
            } else {
                startPosition = e.clientX;
                e.preventDefault();
            }
            
            isDragging = true;
            track.style.cursor = 'grabbing';
            track.style.transition = 'none';
        }
        
        function drag(e) {
            if (!isDragging) return;
            
            let currentPosition = 0;
            if (e.type === 'touchmove') {
                currentPosition = e.touches[0].clientX;
            } else {
                currentPosition = e.clientX;
            }
            
            const diff = currentPosition - startPosition;
            currentTranslate = prevTranslate + diff;
            
            // Limitar o arrasto
            const maxTranslate = maxPosition * slideWidth;
            currentTranslate = Math.max(0, Math.min(currentTranslate, maxTranslate));
            
            track.style.transform = `translateX(-${currentTranslate}px)`;
        }
        
        function dragEnd() {
            isDragging = false;
            track.style.cursor = 'grab';
            track.style.transition = 'transform 0.5s ease';
            
            // Arredondar para a posição mais próxima
            currentPosition = Math.round(currentTranslate / slideWidth);
            currentPosition = Math.max(0, Math.min(currentPosition, maxPosition));
            currentTranslate = currentPosition * slideWidth;
            
            track.style.transform = `translateX(-${currentTranslate}px)`;
            prevTranslate = currentTranslate;
            
            updateButtons();
        }
        
        // Inicializar
        updateButtons();
        
        // Redimensionar janela
        window.addEventListener('resize', () => {
            const newVisibleSlides = Math.floor(track.offsetWidth / slideWidth);
            const newMaxPosition = Math.max(0, slides.length - newVisibleSlides);
            
            if (currentPosition > newMaxPosition) {
                currentPosition = newMaxPosition;
                updateCarousel();
            }
            
            maxPosition = newMaxPosition;
            updateButtons();
        });
    }
});
</script>