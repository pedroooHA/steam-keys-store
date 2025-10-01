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
            $stmt = $pdo->prepare("SELECT g.*, ci.quantity FROM cart_items ci JOIN games g ON ci.game_id = g.id WHERE ci.cart_id = ?");
            $stmt->execute([$cart['id']]);
            $cartItems = $stmt->fetchAll();
        } else {
            // Visitante: Busca da SESSÃO
            if (!empty($_SESSION['cart'])) {
                $gameIds = array_keys($_SESSION['cart']);
                $gamesFromDb = Game::findByIds($gameIds);
                foreach ($gamesFromDb as $game) {
                    $cartItems[] = array_merge($game, ['quantity' => $_SESSION['cart'][$game['id']]]);
                }
            }
        }
        
        foreach ($cartItems as $item) {
            $total += $item['price'] * $item['quantity'];
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
            $stmt = $pdo->prepare("SELECT * FROM cart_items WHERE cart_id = ? AND game_id = ?");
            $stmt->execute([$cart['id'], $gameId]);
            $item = $stmt->fetch();

            if ($item) {
                $stmt = $pdo->prepare("UPDATE cart_items SET quantity = quantity + 1 WHERE id = ?");
                $stmt->execute([$item['id']]);
            } else {
                $stmt = $pdo->prepare("INSERT INTO cart_items (cart_id, game_id, quantity) VALUES (?, ?, 1)");
                $stmt->execute([$cart['id'], $gameId]);
            }
        } else {
            // Visitante
            $_SESSION['cart'][$gameId] = ($_SESSION['cart'][$gameId] ?? 0) + 1;
        }

        header('Location: index.php?route=cart');
        exit;
    }
    // Em controllers/CartController.php
public function remove() {
    $gameId = $_GET['game_id'] ?? null;
    if (!$gameId) {
        header('Location: index.php?route=cart');
        exit;
    }
    if (isset($_SESSION['user_id'])) {
        $pdo = Database::getConnection();
        $cart = Cart::findOrCreateByUserId($_SESSION['user_id']);
        $stmt = $pdo->prepare("DELETE FROM cart_items WHERE cart_id = ? AND game_id = ?");
        $stmt->execute([$cart['id'], $gameId]);
    } else {
        unset($_SESSION['cart'][$gameId]);
    }
    header('Location: index.php?route=cart');
    exit;
}
}