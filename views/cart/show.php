<?php require __DIR__ . '/../layout/header.php'; ?>

<div class="container py-4">
    <!-- Header Melhorado -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="mb-1" style="color: var(--cor-texto-principal);">
                <i class="fas fa-shopping-cart me-2" style="color: var(--cor-botao);"></i>
                Seu Carrinho
            </h1>
            <p class="text-muted mb-0">Revise seus itens antes de finalizar a compra</p>
        </div>
        <a href="index.php" class="btn btn-outline-primary">
            <i class="fas fa-arrow-left me-2"></i>Continuar Comprando
        </a>
    </div>

    <?php if (empty($cartItems)): ?>
        <!-- Estado Vazio Melhorado -->
        <div class="empty-cart text-center py-5">
            <div class="empty-cart-icon mb-4">
                <i class="fas fa-shopping-cart" style="font-size: 4rem; color: var(--cor-botao); opacity: 0.3;"></i>
            </div>
            <h3 style="color: var(--cor-texto-principal);">Seu carrinho está vazio</h3>
            <p class="text-muted mb-4">Descubra jogos incríveis para adicionar à sua coleção</p>
            <a href="index.php" class="btn btn-primary btn-lg">
                <i class="fas fa-gamepad me-2"></i>Explorar Jogos
            </a>
        </div>
    <?php else: ?>
        <div class="row">
            <!-- Lista de Itens -->
            <div class="col-lg-8">
                <div class="cart-items-container">
                    <?php foreach($cartItems as $item):
                        // Lógica inteligente para a imagem
                        $imagePath = htmlspecialchars($item['image'] ?? '');
                        if (filter_var($imagePath, FILTER_VALIDATE_URL)) {
                            $imageUrl = $imagePath;
                        } else if (!empty($imagePath)) {
                            $imageUrl = 'uploads/' . $imagePath;
                        } else {
                            $imageUrl = 'https://via.placeholder.com/100x75/1f2b57/a3b6e6?text=Sem+Imagem';
                        }

                        $price = $item['price'] ?? $item['preco'] ?? $item['preco_unitario'] ?? 0;
                        $subtotal = $price * $item['quantidade'];
                    ?>
                        <div class="cart-item-card" data-game-id="<?php echo $item['id']; ?>">
                            <div class="row align-items-center">
                                <div class="col-md-2">
                                    <img src="<?php echo $imageUrl; ?>"
                                         alt="<?php echo htmlspecialchars($item['title']); ?>"
                                         class="cart-item-image rounded">
                                </div>

                                <div class="col-md-4">
                                    <h5 class="cart-item-title mb-1"><?php echo htmlspecialchars($item['title']); ?></h5>
                                    <div class="platform-badge">
                                        <i class="fa-brands fa-steam me-1"></i>Steam
                                    </div>
                                </div>

                                <div class="col-md-2 text-center">
                                    <span class="cart-item-price">R$ <?php echo number_format($price, 2, ',', '.'); ?></span>
                                </div>

                                <div class="col-md-2">
                                    <div class="quantity-controls">
                                        <button type="button" class="btn btn-sm btn-outline-secondary quantity-btn" data-action="decrease">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                        <span class="quantity-display mx-2"><?php echo $item['quantidade']; ?></span>
                                        <button type="button" class="btn btn-sm btn-outline-secondary quantity-btn" data-action="increase">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </div>
                                </div>

                                <div class="col-md-1 text-end">
                                    <span class="cart-item-subtotal">R$ <?php echo number_format($subtotal, 2, ',', '.'); ?></span>
                                </div>

                                <div class="col-md-1 text-center">
                                    <!-- Link que chama a rota remove. Tem data-game-id e href -->
                                    <a href="index.php?route=cart&action=remove&game_id=<?php echo $item['id']; ?>"
                                       class="btn btn-sm btn-outline-danger remove-item-link"
                                       data-game-id="<?php echo $item['id']; ?>"
                                       title="Remover item">
                                        <i class="fas fa-trash-alt"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Resumo do Pedido -->
            <div class="col-lg-4">
                <div class="order-summary-card">
                    <h4 class="summary-title">
                        <i class="fas fa-receipt me-2"></i>Resumo do Pedido
                    </h4>

                    <div class="summary-details">
                        <div class="summary-row">
                            <span>Subtotal</span>
                            <span>R$ <?php echo number_format($total, 2, ',', '.'); ?></span>
                        </div>

                        <div class="summary-row">
                            <span>Descontos</span>
                            <span class="text-success">- R$ 0,00</span>
                        </div>

                        <div class="summary-row">
                            <span>Taxas</span>
                            <span class="text-muted">Grátis</span>
                        </div>

                        <hr>

                        <div class="summary-row total-row">
                            <strong>Total</strong>
                            <strong style="color: var(--cor-desconto); font-size: 1.2rem;">
                                R$ <?php echo number_format($total, 2, ',', '.'); ?>
                            </strong>
                        </div>
                    </div>

                    <div class="summary-actions mt-4">
                        <button class="btn btn-success btn-lg w-100 checkout-btn">
                            <i class="fas fa-lock me-2"></i>Finalizar Compra
                        </button>

                        <div class="security-badges mt-3 text-center">
                            <small class="text-muted">
                                <i class="fas fa-shield-alt me-1"></i>
                                Compra 100% segura •
                                <i class="fas fa-lock me-1"></i>
                                Pagamento criptografado
                            </small>
                        </div>
                    </div>

                    <!-- Recomendações -->
                    <div class="recommendations mt-4">
                        <h6 class="mb-3">Quem comprou este jogo também comprou:</h6>
                        <div class="recommended-games">
                            <!-- Aqui você pode adicionar jogos recomendados -->
                            <div class="recommended-game">
                                <small>The Witcher 3</small>
                                <small class="text-primary">R$ 49,90</small>
                            </div>
                            <div class="recommended-game">
                                <small>Cyberpunk 2077</small>
                                <small class="text-primary">R$ 89,90</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php require __DIR__ . '/../layout/footer.php'; ?>

<!-- SweetAlert2 (modal bonito) -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
/* Estilos para o Carrinho */
.cart-items-container {
    background: var(--cor-card);
    border-radius: 12px;
    padding: 1.5rem;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

.cart-item-card {
    background: white;
    border-radius: 8px;
    padding: 1.5rem;
    margin-bottom: 1rem;
    border: 1px solid #e9ecef;
    transition: all 0.3s ease;
    background-color: black;
}

.cart-item-card:hover {
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    transform: translateY(-2px);
}

.cart-item-image {
    width: 100%;
    height: 80px;
    object-fit: cover;
}

.cart-item-title {
    color: var(--cor-texto-principal);
    font-weight: 600;
}

h5.cart-item-title.mb-1 {
    color: white;
}

span.cart-item-price {
    color: white;
    font-weight: 600;
}

span.cart-item-subtotal {
    color: white;
    font-weight: 600;
}

span.quantity-display.mx-2 {
    color: white;
    font-weight: 600;
}

.platform-badge {
    background: linear-gradient(135deg, #1b2838, #2a475e);
    color: white;
    padding: 4px 8px;
    border-radius: 6px;
    font-size: 0.75rem;
    display: inline-block;
}

.quantity-controls {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
}

.quantity-display {
    min-width: 30px;
    text-align: center;
    font-weight: 600;
}

.cart-item-price,
.cart-item-subtotal {
    font-weight: 600;
    color: var(--cor-texto-principal);
}

.order-summary-card {
    background: var(--cor-card);
    border-radius: 12px;
    padding: 1.5rem;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    position: sticky;
    top: 2rem;
}

.summary-title {
    color: var(--cor-texto-principal);
    border-bottom: 2px solid var(--cor-botao);
    padding-bottom: 0.5rem;
    margin-bottom: 1rem;
}

.summary-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.5rem 0;
}

text-muted {
    color: red !important;
}

.total-row {
    border-top: 2px solid #e9ecef;
    padding-top: 1rem;
    margin-top: 0.5rem;
}

.checkout-btn {
    background: linear-gradient(135deg, var(--cor-botao), #3a4a8a);
    border: none;
    border-radius: 8px;
    padding: 12px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.checkout-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(58,74,138,0.4);
}

.security-badges {
    opacity: 0.8;
}

.recommended-game {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.5rem 0;
    border-bottom: 1px solid #f1f3f4;
}

.recommended-game:last-child {
    border-bottom: none;
}

.empty-cart {
    background: var(--cor-card);
    border-radius: 12px;
    padding: 4rem 2rem;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

.remove-item-link {
    transition: transform 0.25s ease, background-color 0.3s ease, color 0.3s ease;
}

.remove-item-link:hover {
    background-color: #dc3545;
    color: white;
    transform: scale(1.25);
}

.remove-item-link:active {
    transform: scale(1.15);
}

.quantity-btn {
    transition: all 0.2s ease;
}

.quantity-btn:hover {
    background-color: var(--cor-botao);
    color: white;
}

/* Responsividade */
@media (max-width: 768px) {
    .cart-item-card .row > div {
        margin-bottom: 1rem;
    }

    .cart-item-card .row > div:last-child {
        margin-bottom: 0;
    }

    .quantity-controls {
        justify-content: flex-start;
    }
}

/* SweetAlert customização para combinar com tema */
.swal2-popup {
  background: #1e1b29 !important;
  color: #f3e8ff !important;
  font-family: 'Poppins', sans-serif;
  border-radius: 12px !important;
}
.swal2-title { font-size: 1.2rem; font-weight: 600; }
.swal2-confirm, .swal2-cancel {
  border-radius: 8px !important;
  padding: 8px 14px !important;
  font-weight: 600;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Função de notificação minimalista
    function showNotification(message, type = 'info') {
        const notification = document.createElement('div');
        notification.textContent = message;
        notification.className = `custom-notification ${type}`;
        document.body.appendChild(notification);

        // Animação de entrada
        setTimeout(() => {
            notification.classList.add('show');
        }, 50);

        // Remover depois de 2.5s
        setTimeout(() => {
            notification.classList.remove('show');
            setTimeout(() => notification.remove(), 400);
        }, 2500);
    }

    // Evento de remover item
    document.querySelectorAll('.remove-item-btn').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const gameId = this.getAttribute('data-game-id');
            const itemCard = this.closest('.cart-item-card');

            // Exibe a notificação no estilo do site
            showNotification('Removendo item do carrinho...', 'info');

            // Animação de remoção
            itemCard.style.opacity = '0';
            itemCard.style.transform = 'translateX(80px)';

            setTimeout(() => {
                window.location.href = `index.php?route=cart&action=remove&game_id=${gameId}`;
            }, 600);
        });
    });
});
</script>

<style>
/* === Notificação minimalista estilo preto e branco === */
.custom-notification {
    position: fixed;
    top: 20px;
    right: 20px;
    background: #000;
    color: #fff;
    padding: 14px 22px;
    border-radius: 8px;
    font-size: 0.95rem;
    font-weight: 500;
    box-shadow: 0 4px 12px rgba(0,0,0,0.2);
    opacity: 0;
    transform: translateY(-10px);
    transition: all 0.4s ease;
    z-index: 9999;
    letter-spacing: 0.3px;
}

/* Animação de entrada/saída */
.custom-notification.show {
    opacity: 1;
    transform: translateY(0);
}

/* Tipos de mensagem (tons neutros) */
.custom-notification.info {
    background: #000;
    color: #fff;
    border: 1px solid #333;
}

.custom-notification.success {
    background: #111;
    border: 1px solid #444;
}

.custom-notification.error {
    background: #fff;
    color: #000;
    border: 1px solid #000;
}
</style>
