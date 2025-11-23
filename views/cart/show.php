<?php require __DIR__ . '/../layout/header.php'; ?>

<div class="page-container">
    <!-- Header Melhorado -->
    <div class="page-header">
        <h1>
            <i class="fas fa-shopping-cart me-2"></i>
            Seu Carrinho
        </h1>
        <p class="text-muted mb-0">Revise seus itens antes de finalizar a compra</p>
    </div>

    <?php if (empty($cartItems)): ?>
        <!-- Estado Vazio Melhorado -->
        <div class="empty-state">
            <i class="fas fa-shopping-cart"></i>
            <h3>Seu carrinho está vazio</h3>
            <p>Descubra jogos incríveis para adicionar à sua coleção</p>
            <a href="index.php" class="btn btn-primary mt-3">
                <i class="fas fa-gamepad me-2"></i>Explorar Jogos
            </a>
        </div>
    <?php else: ?>
        <div class="row">
            <!-- Lista de Itens -->
            <div class="col-lg-8">
                <div class="catalogo-wrapper p-4 shadow-sm rounded-4">
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
                        <div class="cart-item-card mb-3" data-game-id="<?php echo $item['id']; ?>">
                            <div class="row align-items-center">
                                <div class="col-md-2">
                                    <img src="<?php echo $imageUrl; ?>"
                                         alt="<?php echo htmlspecialchars($item['title']); ?>"
                                         class="cart-item-image rounded">
                                </div>

                                <div class="col-md-6">
                                    <h5 class="cart-item-title mb-1"><?php echo htmlspecialchars($item['title']); ?></h5>
                                    <div class="steam-badge-custom">
                                        <i class="fa-brands fa-steam"></i>
                                        <span>Steam</span>
                                    </div>
                                </div>

                                <div class="col-md-3 text-end">
                                    <span class="final-price-custom">R$ <?php echo number_format($price, 2, ',', '.'); ?></span>
                                </div>

                                <div class="col-md-1 text-end">
                                    <a href="index.php?route=cart&action=remove&game_id=<?php echo $item['id']; ?>"
                                       class="remove-btn-custom"
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
                            <strong class="final-price-custom">
                                R$ <?php echo number_format($total, 2, ',', '.'); ?>
                            </strong>
                        </div>
                    </div>

  <button class="add-to-cart-btn-custom w-100 checkout-btn"
        data-bs-toggle="modal" data-bs-target="#paymentModal">
    <i class="fas fa-lock me-2"></i> Finalizar Compra
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
                            <div class="recommended-game">
                                <small>The Witcher 3</small>
                                <small class="final-price-custom">R$ 49,90</small>
                            </div>
                            <div class="recommended-game">
                                <small>Cyberpunk 2077</small>
                                <small class="final-price-custom">R$ 89,90</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<!-- Modal de Pagamento Reformulado -->
<div class="modal fade" id="paymentModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content payment-modal-content">
      
      <div class="modal-header payment-modal-header">
        <h5 class="modal-title">
          <i class="fas fa-credit-card me-2"></i>
          Finalizar Compra
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body p-4">
        <!-- Resumo do Pedido -->
        <div class="order-summary-modal mb-4 p-3">
          <h6 class="summary-subtitle mb-3">Resumo do Pedido</h6>
          <div class="d-flex justify-content-between align-items-center mb-2">
            <span class="text-muted">Subtotal:</span>
            <span>R$ <?php echo number_format($total, 2, ',', '.'); ?></span>
          </div>
          <div class="d-flex justify-content-between align-items-center mb-2">
            <span class="text-muted">Descontos:</span>
            <span class="text-success">- R$ 0,00</span>
          </div>
          <div class="d-flex justify-content-between align-items-center mb-3">
            <span class="text-muted">Taxas:</span>
            <span class="text-muted">Grátis</span>
          </div>
          <hr>
          <div class="d-flex justify-content-between align-items-center">
            <strong>Total:</strong>
            <strong class="final-price-custom">R$ <?php echo number_format($total, 2, ',', '.'); ?></strong>
          </div>
        </div>

        <h6 class="mb-3">Escolha o método de pagamento:</h6>
        
        <div class="payment-options">
          <!-- PIX -->
          <div class="payment-option-card mb-3">
            <div class="form-check">
              <input class="form-check-input" type="radio" name="paymentMethod" id="pixOption" value="pix" checked>
              <label class="form-check-label w-100" for="pixOption">
                <div class="d-flex align-items-center">
                  <div class="payment-icon me-3">
                    <i class="fas fa-qrcode"></i>
                  </div>
                  <div class="flex-grow-1">
                    <h6 class="mb-1">PIX</h6>
                    <p class="text-muted mb-0 small">Pagamento instantâneo • Sem taxas</p>
                  </div>
                </div>
              </label>
            </div>
          </div>

          <!-- CARTÃO DE CRÉDITO -->
          <div class="payment-option-card">
            <div class="form-check">
              <input class="form-check-input" type="radio" name="paymentMethod" id="cardOption" value="card">
              <label class="form-check-label w-100" for="cardOption">
                <div class="d-flex align-items-center">
                  <div class="payment-icon me-3">
                    <i class="far fa-credit-card"></i>
                  </div>
                  <div class="flex-grow-1">
                    <h6 class="mb-1">Cartão de Crédito</h6>
                    <p class="text-muted mb-0 small">Até 12x sem juros • Todas as bandeiras</p>
                  </div>
                </div>
              </label>
            </div>
          </div>
        </div>

        <!-- Botão de Confirmação -->
        <div class="mt-4">
          <button type="button" class="confirm-payment-btn w-100" id="confirmPayment">
            <i class="fas fa-lock me-2"></i>
            Confirmar Pagamento
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
      </div>

    </div>
  </div>
</div>

<style>
/* ESTILOS DO MODAL DE PAGAMENTO */
.payment-modal-content {
  border-radius: 16px;
  box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
  border: none;
  overflow: hidden;
}

.payment-modal-header {
  background: linear-gradient(135deg, #000000, #333333);
  color: white;
  border-bottom: none;
  padding: 1.25rem 1.5rem;
}

.payment-modal-header .modal-title {
  font-weight: 700;
  font-size: 1.2rem;
  margin: 0;
}

.payment-modal-header .btn-close {
  filter: invert(1);
  opacity: 0.8;
  margin: 0;
}

.order-summary-modal {
  background: #f8f9fa;
  border-radius: 12px;
  border: 1px solid #e9ecef;
}

.summary-subtitle {
  font-weight: 600;
  color: #000000;
  font-size: 0.9rem;
}

.payment-option-card {
  background: #ffffff;
  border-radius: 12px;
  border: 2px solid #f0f0f0;
  padding: 1rem;
  transition: all 0.3s ease;
  cursor: pointer;
}

.payment-option-card:hover {
  border-color: #000000;
  transform: translateY(-2px);
}

.payment-option-card .form-check-input:checked {
  background-color: #000000;
  border-color: #000000;
}

.payment-option-card .form-check-input {
  margin-top: 0.3rem;
}

.payment-icon {
  font-size: 1.5rem;
  color: #000000;
  width: 40px;
  text-align: center;
}

.payment-option-card h6 {
  font-weight: 600;
  color: #000000;
  margin: 0;
}

.confirm-payment-btn {
  background: linear-gradient(135deg, #000000, #333333);
  color: white;
  border: none;
  border-radius: 10px;
  padding: 12px 20px;
  font-size: 1rem;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.3s ease;
}

.confirm-payment-btn:hover {
  background: linear-gradient(135deg, #333333, #555555);
  transform: translateY(-2px);
}

.security-badges {
  opacity: 0.8;
}

/* Ajustes para o modal ficar centralizado e com tamanho adequado */
.modal-dialog {
  max-width: 450px;
}

/* Responsividade */
@media (max-width: 576px) {
  .modal-dialog {
    margin: 1rem;
  }
  
  .payment-modal-header {
    padding: 1rem 1.25rem;
  }
  
  .modal-body {
    padding: 1.25rem;
  }
  
  .payment-option-card {
    padding: 0.75rem;
  }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
  // Configuração do modal de pagamento
  const confirmPaymentBtn = document.getElementById('confirmPayment');
  
  if (confirmPaymentBtn) {
    confirmPaymentBtn.addEventListener('click', function() {
      const selectedMethod = document.querySelector('input[name="paymentMethod"]:checked').value;
      
      // Mostrar loading
      const originalText = confirmPaymentBtn.innerHTML;
      confirmPaymentBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Processando...';
      confirmPaymentBtn.disabled = true;
      
      // Simular processamento
      setTimeout(() => {
        // Redirecionar para o método de pagamento selecionado
        if (selectedMethod === 'pix') {
          window.location.href = 'index.php?route=payment&action=process&method=pix';
        } else if (selectedMethod === 'card') {
          window.location.href = 'index.php?route=payment&action=process&method=card';
        }
      }, 1500);
    });
  }
  
  // Fechar modal com ESC
  document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
      const modal = document.getElementById('paymentModal');
      if (modal) {
        const bsModal = bootstrap.Modal.getInstance(modal);
        if (bsModal) {
          bsModal.hide();
        }
      }
    }
  });
});
</script>
          </div>

        </div>
      </div>

    </div>
  </div>
</div>


<?php require __DIR__ . '/../layout/footer.php'; ?>

<!-- SweetAlert2 (modal bonito) -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
/* ESTILOS CONSISTENTES COM OS OUTROS CARDS */

.payment-btn {
    background: linear-gradient(45deg, #5d5c5cff, #000000ff);  /* azul gamer */
    border: none;
    color: white;
    padding: 12px 20px;
    border-radius: 10px;
    font-size: 16px;
    cursor: pointer;
    transition: 0.3s;
}

.payment-btn:hover {
    transform: scale(1.05);
    opacity: 0.9;
}

.page-container {
    max-width: 1400px;
    margin: 0 auto;
    padding: 30px 20px;
}

.page-header {
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
    margin-bottom: 40px;
    padding: 0 10px;
}

.page-header h1 {
    font-size: 2.2rem;
    font-weight: 700;
    color: #000000;
    letter-spacing: -0.5px;
    margin-bottom: 0.5rem;
}

.catalogo-wrapper {
    background: white;
    border-radius: 1.5rem;
    box-shadow: 0 4px 12px rgba(0,0,0,0.05);
}

/* ESTILOS DOS ITENS DO CARRINHO */
.cart-item-card {
    background: #ffffff;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    border: 1px solid #f0f0f0;
    transition: all 0.3s ease;
    overflow: hidden;
    display: flex;
    flex-direction: column;
    padding: 1.5rem;
    margin-bottom: 1rem;
}

.cart-item-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 12px 35px rgba(0, 0, 0, 0.15);
}

.cart-item-image {
    width: 100%;
    height: 80px;
    object-fit: cover;
    border-radius: 8px;
}

.cart-item-title {
    font-size: 1.1rem;
    font-weight: 700;
    color: #000000;
    line-height: 1.3;
    margin: 0;
}

.steam-badge-custom {
    background: linear-gradient(135deg, #1b2838, #2a475e);
    color: #ffffff;
    padding: 6px 10px;
    border-radius: 8px;
    font-size: 0.75rem;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 5px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
    margin-top: 0.5rem;
}

.final-price-custom {
    font-size: 1.3rem;
    font-weight: 700;
    color: #000000ff;
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
    display: inline-flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
    width: 45px;
    height: 45px;
}

.remove-btn-custom:hover {
    background: #e74c3c;
    color: white;
    transform: translateY(-2px);
}

/* RESUMO DO PEDIDO */
.order-summary-card {
    background: #ffffff;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    border: 1px solid #f0f0f0;
    padding: 1.5rem;
    position: sticky;
    top: 2rem;
}

.summary-title {
    font-size: 1.3rem;
    font-weight: 700;
    color: #000000;
    border-bottom: 2px solid #000000;
    padding-bottom: 0.5rem;
    margin-bottom: 1rem;
}

.summary-details {
    margin-bottom: 1rem;
}

.summary-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.5rem 0;
    color: #000000;
}

.total-row {
    border-top: 2px solid #e9ecef;
    padding-top: 1rem;
    margin-top: 0.5rem;
    font-size: 1.2rem;
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

/* ESTADO VAZIO */
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

/* RESPONSIVIDADE */
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
    
    .cart-item-title {
        font-size: 1rem;
    }
    
    .final-price-custom {
        font-size: 1.1rem;
    }
    
    .cart-item-card .row > div {
        margin-bottom: 1rem;
    }

    .cart-item-card .row > div:last-child {
        margin-bottom: 0;
    }
}

@media (max-width: 480px) {
    .cart-item-image {
        height: 60px;
    }
    
    .cart-item-title {
        font-size: 0.9rem;
    }
    
    .final-price-custom {
        font-size: 1rem;
    }
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
    document.querySelectorAll('.remove-btn-custom').forEach(button => {
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

    // Botão finalizar compra
    document.querySelector('.checkout-btn')?.addEventListener('click', function() {
        showNotification('Processando sua compra...', 'success');
        // Aqui você pode adicionar a lógica de finalização de compra
    });
});
</script>