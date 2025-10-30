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
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $cartItems = [];
        $total = 0;

        // Usuário logado
        if (isset($_SESSION['user_id'])) {
            $pdo = Database::getConnection();

            // Busca os jogos do carrinho do usuário logado
            $stmt = $pdo->prepare("
                SELECT g.*, c.quantidade, c.preco_unitario
                FROM cart c
                JOIN games g ON c.id_jogo = g.id
                WHERE c.id_usuario = ?
            ");
            $stmt->execute([$_SESSION['user_id']]);
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
            $price = isset($item['price']) ? $item['price'] :
                     (isset($item['preco']) ? $item['preco'] :
                     (isset($item['preco_unitario']) ? $item['preco_unitario'] : 0));
            $total += $price * $item['quantidade'];
        }

        require_once dirname(__DIR__) . '/views/cart/show.php';
    }

    /**
     * Adiciona um jogo ao carrinho
     */
    public function add()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $gameId = $_POST['game_id'] ?? null;
        if (!$gameId) {
            header('Location: index.php');
            exit;
        }

        // Usuário logado
        if (isset($_SESSION['user_id'])) {
            $pdo = Database::getConnection();

            // Verifica se o jogo já está no carrinho
            $stmt = $pdo->prepare("
                SELECT * FROM cart 
                WHERE id_usuario = ? AND id_jogo = ?
            ");
            $stmt->execute([$_SESSION['user_id'], $gameId]);
            $item = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($item) {
                $stmt = $pdo->prepare("
                    UPDATE cart 
                    SET quantidade = quantidade + 1 
                    WHERE id = ?
                ");
                $stmt->execute([$item['id']]);
            } else {
                // Busca o preço atual do jogo
                $gstmt = $pdo->prepare("SELECT price FROM games WHERE id = ?");
                $gstmt->execute([$gameId]);
                $g = $gstmt->fetch(PDO::FETCH_ASSOC);
                $price = $g ? ($g['price'] ?? $g['preco'] ?? 0) : 0;

                $stmt = $pdo->prepare("
                    INSERT INTO cart (id_usuario, id_jogo, quantidade, preco_unitario)
                    VALUES (?, ?, 1, ?)
                ");
                $stmt->execute([$_SESSION['user_id'], $gameId, $price]);
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
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $gameId = $_GET['game_id'] ?? null;
        if (!$gameId) {
            header('Location: index.php?route=cart');
            exit;
        }

        // Usuário logado
        if (isset($_SESSION['user_id'])) {
            $pdo = Database::getConnection();

            $stmt = $pdo->prepare("
                SELECT * FROM cart 
                WHERE id_usuario = ? AND id_jogo = ?
            ");
            $stmt->execute([$_SESSION['user_id'], $gameId]);
            $item = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($item && $item['quantidade'] > 1) {
                $stmt = $pdo->prepare("
                    UPDATE cart 
                    SET quantidade = quantidade - 1 
                    WHERE id = ?
                ");
                $stmt->execute([$item['id']]);
            } else {
                $stmt = $pdo->prepare("
                    DELETE FROM cart 
                    WHERE id_usuario = ? AND id_jogo = ?
                ");
                $stmt->execute([$_SESSION['user_id'], $gameId]);
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
