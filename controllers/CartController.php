<?php

class CartController
{
    public function show()
    {
        $cartItems = [];
        $total = 0;

        if (isset($_SESSION['user_id'])) {
            // Usuário LOGADO: Busca do Banco de Dados
            $pdo = Database::getConnection();
            $cart = Cart::findOrCreateByUserId($_SESSION['user_id']);
            $stmt = $pdo->prepare("SELECT g.*, ic.quantidade FROM itens_carrinho ic JOIN games g ON ic.id_jogo = g.id WHERE ic.id_carrinho = ?");
            $stmt->execute([$cart['id']]);
            $cartItems = $stmt->fetchAll();
        } else {
            // Visitante: Busca da SESSÃO
            if (!empty($_SESSION['cart'])) {
                $gameIds = array_keys($_SESSION['cart']);
                $gamesFromDb = Game::findByIds($gameIds);
                foreach ($gamesFromDb as $game) {
                    // CORREÇÃO: usar 'quantidade' em vez de 'quantity'
                    $cartItems[] = array_merge($game, ['quantidade' => $_SESSION['cart'][$game['id']]]);
                }
            }
        }
        
        foreach ($cartItems as $item) {
            $total += $item['price'] * $item['quantidade'];
        }

        require_once dirname(__DIR__) . '/views/cart/show.php';
    }

    public function add()
    {
        $gameId = $_POST['game_id'] ?? null;
        if (!$gameId) { header('Location: index.php'); exit; }

        if (isset($_SESSION['user_id'])) {
            // Usuário LOGADO
            $pdo = Database::getConnection();
            $cart = Cart::findOrCreateByUserId($_SESSION['user_id']);
            $stmt = $pdo->prepare("SELECT * FROM itens_carrinho WHERE id_carrinho = ? AND id_jogo = ?");
            $stmt->execute([$cart['id'], $gameId]);
            $item = $stmt->fetch();

            if ($item) {
                $stmt = $pdo->prepare("UPDATE itens_carrinho SET quantidade = quantidade + 1 WHERE id = ?");
                $stmt->execute([$item['id']]);
            } else {
                $stmt = $pdo->prepare("INSERT INTO itens_carrinho (id_carrinho, id_jogo, quantidade) VALUES (?, ?, 1)");
                $stmt->execute([$cart['id'], $gameId]);
            }
        } else {
            // Visitante
            $_SESSION['cart'][$gameId] = ($_SESSION['cart'][$gameId] ?? 0) + 1;
        }

        header('Location: index.php?route=cart');
        exit;
    }

    public function remove() {
        $gameId = $_GET['game_id'] ?? null;
        if (!$gameId) {
            header('Location: index.php?route=cart');
            exit;
        }
        if (isset($_SESSION['user_id'])) {
            $pdo = Database::getConnection();
            $cart = Cart::findOrCreateByUserId($_SESSION['user_id']);
            // CORREÇÃO: usar nomes em português
            $stmt = $pdo->prepare("DELETE FROM itens_carrinho WHERE id_carrinho = ? AND id_jogo = ?");
            $stmt->execute([$cart['id'], $gameId]);
        } else {
            unset($_SESSION['cart'][$gameId]);
        }
        header('Location: index.php?route=cart');
        exit;
    }
}