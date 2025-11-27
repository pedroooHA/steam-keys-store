<?php

class PaymentController
{
    public function process()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?route=login");
            exit;
        }

        if (!isset($_POST['payment_method'])) {
            require __DIR__ . '/../views/payment/select.php';
            return;
        }

        $paymentMethod = $_POST['payment_method'];
        
        if ($paymentMethod === 'pix') {
            $this->processPixPayment();
        } elseif ($paymentMethod === 'card') {
            $this->processCardPayment();
        } else {
            $_SESSION['error'] = 'Método de pagamento inválido';
            header("Location: index.php?route=cart");
            exit;
        }
    }

    public function processPixPayment()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?route=login");
            exit;
        }

        // Processar o pagamento PIX
        $success = $this->finalizePurchase('pix');
        
        if ($success) {
            header("Location: index.php?route=payment&action=success&method=pix");
        } else {
            header("Location: index.php?route=payment&action=failed");
        }
        exit;
    }

    public function processCardPayment()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?route=login");
            exit;
        }

        // Validar dados do cartão (simplificado)
        if (!$this->validateCardData($_POST)) {
            $_SESSION['error'] = 'Dados do cartão inválidos';
            header("Location: index.php?route=payment&action=card");
            exit;
        }

        $success = $this->finalizePurchase('credit_card');
        
        if ($success) {
            header("Location: index.php?route=payment&action=success&method=card");
        } else {
            header("Location: index.php?route=payment&action=failed");
        }
        exit;
    }

    private function validateCardData($data)
    {
        // Validações básicas do cartão
        if (empty($data['card_number']) || empty($data['card_holder']) || 
            empty($data['card_expiry']) || empty($data['card_cvv'])) {
            return false;
        }

        return true;
    }

    public function finalizePurchase($paymentMethod = 'unknown')
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user_id'])) {
            return false;
        }

        $userId = $_SESSION['user_id'];

        require_once dirname(__DIR__) . '/models/Cart.php';
        require_once dirname(__DIR__) . '/models/Game.php';

        try {
            // Obter itens do carrinho
            $items = Cart::getItemsByUserId($userId);

            if (empty($items)) {
                $_SESSION['error'] = 'Carrinho vazio';
                return false;
            }

            // Verificar estoque antes de processar
            if (!$this->checkStock($items)) {
                $_SESSION['error'] = 'Estoque insuficiente para alguns itens';
                return false;
            }

            // Criar pedido no banco de dados
            $orderId = $this->createOrder($userId, $items, $paymentMethod);
            
            if (!$orderId) {
                throw new Exception('Falha ao criar pedido');
            }

            // Reduzir estoque - USA SEU MÉTODO EXISTENTE
            foreach ($items as $item) {
                $quantidadeVendida = $item['quantidade'] ?? 1;
                $gameId = $item['id'];
                
                // Usa o método reduzirEstoque do seu Model Game
                $success = Game::reduzirEstoque($gameId, $quantidadeVendida);
                
                if (!$success) {
                    throw new Exception("Falha ao reduzir estoque do jogo ID: $gameId");
                }
            }

            // Limpar carrinho
            Cart::clearCart($userId);

            // Registrar sucesso
            $_SESSION['success'] = 'Compra realizada com sucesso!';
            $_SESSION['order_id'] = $orderId;

            return true;

        } catch (Exception $e) {
            error_log("Erro ao finalizar compra: " . $e->getMessage());
            $_SESSION['error'] = 'Erro ao processar compra: ' . $e->getMessage();
            return false;
        }
    }

    private function checkStock($items)
    {
        require_once dirname(__DIR__) . '/models/Game.php';
        
        foreach ($items as $item) {
            $gameId = $item['id'];
            $quantidadeRequerida = $item['quantidade'] ?? 1;
            
            // Buscar informações do jogo para verificar estoque
            $game = Game::find($gameId);
            if (!$game || $game['estoque'] < $quantidadeRequerida) {
                error_log("Estoque insuficiente: Game ID $gameId - Requerido: $quantidadeRequerida - Disponível: " . ($game['estoque'] ?? 0));
                return false;
            }
        }
        return true;
    }

    private function createOrder($userId, $items, $paymentMethod)
    {
        require_once dirname(__DIR__) . '/config/database.php';
        
        try {
            $pdo = Database::getConnection();
            
            // Calcular total
            $total = 0;
            foreach ($items as $item) {
                $price = $item['price'] ?? $item['preco'] ?? 0;
                $quantidade = $item['quantidade'] ?? 1;
                $total += $price * $quantidade;
            }

            // Inserir pedido
            $sql = "INSERT INTO pedidos (user_id, payment_method, status, total, created_at) 
                    VALUES (?, ?, 'completed', ?, NOW())";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$userId, $paymentMethod, $total]);
            $orderId = $pdo->lastInsertId();

            // Inserir itens do pedido
            foreach ($items as $item) {
                $price = $item['price'] ?? $item['preco'] ?? 0;
                $quantidade = $item['quantidade'] ?? 1;
                
                $sql = "INSERT INTO pedido_itens (pedido_id, game_id, quantidade, preco_unitario) 
                        VALUES (?, ?, ?, ?)";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$orderId, $item['id'], $quantidade, $price]);
            }

            return $orderId;

        } catch (Exception $e) {
            error_log("Erro ao criar pedido: " . $e->getMessage());
            return false;
        }
    }

    public function success()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $method = $_GET['method'] ?? 'unknown';
        $orderId = $_SESSION['order_id'] ?? null;

        // Limpar sessão após exibir sucesso
        unset($_SESSION['order_id']);
        unset($_SESSION['success']);

        require __DIR__ . '/../views/payment/success.php';
    }

    public function failed()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $error = $_SESSION['error'] ?? 'Erro desconhecido ao processar pagamento';
        
        // Limpar mensagem de erro após exibir
        unset($_SESSION['error']);
        
        require __DIR__ . '/../views/payment/failed.php';
    }
}