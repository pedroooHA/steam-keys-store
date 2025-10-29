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
        $stmt = $pdo->prepare("SELECT * FROM cart WHERE id_usuario = ?");
        $stmt->execute([$userId]);
        $cart = $stmt->fetch();

        if ($cart) {
            return $cart;
        }

        $stmt = $pdo->prepare("INSERT INTO cart (id_usuario) VALUES (?)");
        $stmt->execute([$userId]);

        return [
            'id' => $pdo->lastInsertId(),
            'id_utilizador' => $userId
        ];
    }
}