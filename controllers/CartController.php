<?php

require_once dirname(__DIR__) . '/models/Cart.php';
require_once dirname(__DIR__) . '/models/Game.php';
require_once dirname(__DIR__) . '/config/Database.php';

class CartController
{
    /**
     * Exibe o carrinho do usuário (logado ou visitante)
     */
    public function show()
    {
        $cartItems = [];
        $total = 0;

        // Usuário logado
        if (isset($_SESSION['user_id'])) {
            $pdo = Database::getConnection();
            $cart = Cart::findOrCreateByUserId($_SESSION['user_id']);

            $stmt = $pdo->prepare("
                SELECT g.*, ic.quantidade 
                FROM itens_carrinho ic
                JOIN games g ON ic.id_jogo = g.id
                WHERE ic.id_carrinho = ?
            ");
            $stmt->execute([$cart['id']]);
            $cartItems = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } 
        // Visitante (sem login)
        else {
            if (!empty($_SESSION['cart'])) {
                $gameIds = array_keys($_SESSION['cart']);
                $gamesFromDb = Game::findByIds($gameIds);

                foreach ($gamesFromDb as $game) {
                    $cartItems[] = array_merge($game, [
                        'quantidade' => $_SESSION['cart'][$game['id']]
                    ]);
                }
            }
        }

        // Calcular total do carrinho
        foreach ($cartItems as $item) {
            $total += $item['price'] * $item['quantidade'];
        }

        require_once dirname(__DIR__) . '/views/cart/show.php';
    }

    /**
     * Adiciona um jogo ao carrinho
     */
    public function add()
    {
        $gameId = $_POST['game_id'] ?? null;
        if (!$gameId) {
            header('Location: index.php');
            exit;
        }

        // Usuário logado
        if (isset($_SESSION['user_id'])) {
            $pdo = Database::getConnection();
            $cart = Cart::findOrCreateByUserId($_SESSION['user_id']);

            // Verifica se o jogo já está no carrinho
            $stmt = $pdo->prepare("
                SELECT * FROM itens_carrinho 
                WHERE id_carrinho = ? AND id_jogo = ?
            ");
            $stmt->execute([$cart['id'], $gameId]);
            $item = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($item) {
                $stmt = $pdo->prepare("
                    UPDATE itens_carrinho 
                    SET quantidade = quantidade + 1 
                    WHERE id = ?
                ");
                $stmt->execute([$item['id']]);
            } else {
                $stmt = $pdo->prepare("
                    INSERT INTO itens_carrinho (id_carrinho, id_jogo, quantidade)
                    VALUES (?, ?, 1)
                ");
                $stmt->execute([$cart['id'], $gameId]);
            }
        } 
        // Visitante
        else {
            if (!isset($_SESSION['cart'])) {
                $_SESSION['cart'] = [];
            }

            $_SESSION['cart'][$gameId] = ($_SESSION['cart'][$gameId] ?? 0) + 1;
        }

        header('Location: index.php?route=cart');
        exit;
    }

    /**
     * Remove um jogo do carrinho (diminui quantidade ou apaga)
     */
    public function remove()
    {
        $gameId = $_GET['game_id'] ?? null;
        if (!$gameId) {
            header('Location: index.php?route=cart');
            exit;
        }

        // Usuário logado
        if (isset($_SESSION['user_id'])) {
            $pdo = Database::getConnection();
            $cart = Cart::findOrCreateByUserId($_SESSION['user_id']);

            // Busca o item
            $stmt = $pdo->prepare("
                SELECT * FROM itens_carrinho 
                WHERE id_carrinho = ? AND id_jogo = ?
            ");
            $stmt->execute([$cart['id'], $gameId]);
            $item = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($item && $item['quantidade'] > 1) {
                $stmt = $pdo->prepare("
                    UPDATE itens_carrinho 
                    SET quantidade = quantidade - 1 
                    WHERE id = ?
                ");
                $stmt->execute([$item['id']]);
            } else {
                $stmt = $pdo->prepare("
                    DELETE FROM itens_carrinho 
                    WHERE id_carrinho = ? AND id_jogo = ?
                ");
                $stmt->execute([$cart['id'], $gameId]);
            }
        } 
        // Visitante
        else {
            if (isset($_SESSION['cart'][$gameId])) {
                $_SESSION['cart'][$gameId]--;
                if ($_SESSION['cart'][$gameId] <= 0) {
                    unset($_SESSION['cart'][$gameId]);
                }
            }
        }

        header('Location: index.php?route=cart');
        exit;
    }
}
