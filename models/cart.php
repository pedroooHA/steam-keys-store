<?php

class Cart
{
    /**
     * Encontra ou cria um carrinho para um usuário específico.
     * @param int $userId O ID do usuário.
     * @return array Os dados do carrinho.
     */
    public static function findOrCreateByUserId($userId)
    {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("SELECT * FROM carts WHERE user_id = ?");
        $stmt->execute([$userId]);
        $cart = $stmt->fetch();

        if ($cart) {
            return $cart;
        }

        $stmt = $pdo->prepare("INSERT INTO carts (user_id) VALUES (?)");
        $stmt->execute([$userId]);

        return [
            'id' => $pdo->lastInsertId(),
            'user_id' => $userId
        ];
    }
}