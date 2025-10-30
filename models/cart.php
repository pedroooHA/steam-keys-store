<?php
require_once dirname(__DIR__) . '/config/Database.php';

class Cart
{
    /**
     * Encontra ou cria um carrinho para um usuário específico.
     * @param int $userId O ID do usuário.
     * @return array Os dados do carrinho (com 'id' e 'id_usuario').
     */
    public static function findOrCreateByUserId($userId)
    {
        $pdo = Database::getConnection();

        // Tenta encontrar um carrinho existente
        $stmt = $pdo->prepare("SELECT * FROM cart WHERE id_usuario = ?");
        $stmt->execute([$userId]);
        $cart = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($cart) {
            return $cart; // contém 'id' e 'id_usuario'
        }

        // Cria um novo carrinho para o usuário
        $stmt = $pdo->prepare("INSERT INTO cart (id_usuario) VALUES (?)");
        $stmt->execute([$userId]);

        $newId = $pdo->lastInsertId();

        return [
            'id' => (int)$newId,
            'id_usuario' => (int)$userId
        ];
    }
}
