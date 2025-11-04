<?php
class WishlistModel {
    private $pdo;

    public function __construct() {
        $this->pdo = Database::getConnection();
    }

    public function adicionar($usuario_id, $jogo_id) {
        $stmt = $this->pdo->prepare(
            "INSERT INTO wishlist (usuario_id, jogo_id) VALUES (?, ?)"
        );
        return $stmt->execute([$usuario_id, $jogo_id]);
    }

    public function remover($usuario_id, $jogo_id) {
        $stmt = $this->pdo->prepare(
            "DELETE FROM wishlist WHERE usuario_id = ? AND jogo_id = ?"
        );
        return $stmt->execute([$usuario_id, $jogo_id]);
    }

    public function listarPorUsuario($usuario_id) {
        $stmt = $this->pdo->prepare("
            SELECT g.*, w.data_criacao 
            FROM wishlist w 
            INNER JOIN games g ON w.jogo_id = g.id 
            WHERE w.usuario_id = ? 
            ORDER BY w.data_criacao DESC
        ");
        $stmt->execute([$usuario_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function verificarExistente($usuario_id, $jogo_id) {
        $stmt = $this->pdo->prepare(
            "SELECT id FROM wishlist WHERE usuario_id = ? AND jogo_id = ?"
        );
        $stmt->execute([$usuario_id, $jogo_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC) !== false;
    }
}
?>