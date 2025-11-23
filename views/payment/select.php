<h2>Escolha o método de pagamento</h2>

<form method="POST" action="index.php?route=payment&action=process">
    <div>
        <input type="radio" name="payment_method" value="pix" required> PIX
    </div>
    <div>
        <input type="radio" name="payment_method" value="card" required> Cartão de Crédito
    </div>
    <button type="submit">Continuar</button>
</form>
