<?php require __DIR__ . '/../layout/header.php'; ?>

<div class="payment-container">
    <h2>Escolha a forma de pagamento</h2>

    <form action="index.php?route=payment&action=process" method="POST">
        <label>
            <input type="radio" name="payment_method" value="pix" required> PIX
        </label><br>

        <label>
            <input type="radio" name="payment_method" value="card" required> Cartão de Crédito
        </label><br><br>

        <div id="card-fields" style="display: none;">
            <input type="text" name="card_number" placeholder="Número do cartão" class="form-control"><br>
            <input type="text" name="card_name" placeholder="Nome no cartão" class="form-control"><br>
            <input type="text" name="card_expiry" placeholder="Validade (MM/AA)" class="form-control"><br>
            <input type="text" name="card_cvv" placeholder="CVV" class="form-control"><br>
        </div>

        <button type="submit" class="add-to-cart-btn-custom w-100">
            Finalizar Pagamento
        </button>
    </form>
</div>

<script>
document.querySelectorAll('input[name="payment_method"]').forEach(radio => {
    radio.addEventListener('change', () => {
        document.getElementById('card-fields').style.display =
            radio.value === 'card' ? 'block' : 'none';
    });
});
</script>

<?php require __DIR__ . '/../layout/footer.php'; ?>
