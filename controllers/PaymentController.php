<?php

class PaymentController
{
   public function process()
{
    if (!isset($_POST['payment_method'])) {
        // exibir a tela de seleção de pagamento
        require __DIR__ . '/../views/payment/select.php';
        return;
    }

    if ($_POST['payment_method'] === 'pix') {
        header("Location: index.php?route=payment&action=pix");
        exit;
    }

    if ($_POST['payment_method'] === 'card') {
        header("Location: index.php?route=payment&action=card");
        exit;
    }
}

}
