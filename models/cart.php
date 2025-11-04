<?php
require_once dirname(__DIR__) . '/config/Database.php';

class Cart
{
    /**
     * Retorna o carrinho completo de um usuário (com jogos e totais)
     */
    public static function getItemsByUserId($userId)
    {
        $pdo = Database::getConnection();

        $stmt = $pdo->prepare("
            SELECT 
                g.id,
                g.title,
                g.price,
                g.image,
                c.quantidade,
                c.preco_unitario
            FROM cart c
            JOIN games g ON c.id_jogo = g.id
            WHERE c.id_usuario = ?
        ");
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Adiciona um jogo ao carrinho (ou aumenta quantidade se já existir)
     */
    public static function addItem($userId, $gameId, $price)
    {
        $pdo = Database::getConnection();

        // Verifica se já existe
        $stmt = $pdo->prepare("SELECT * FROM cart WHERE id_usuario = ? AND id_jogo = ?");
        $stmt->execute([$userId, $gameId]);
        $existing = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($existing) {
            // Atualiza quantidade
            $stmt = $pdo->prepare("UPDATE cart SET quantidade = quantidade + 1 WHERE id_usuario = ? AND id_jogo = ?");
            return $stmt->execute([$userId, $gameId]);
        } else {
            // Adiciona novo item
            $stmt = $pdo->prepare("INSERT INTO cart (id_usuario, id_jogo, quantidade, preco_unitario) VALUES (?, ?, 1, ?)");
            return $stmt->execute([$userId, $gameId, $price]);
        }
    }

    /**
     * Remove um jogo específico do carrinho
     */
    public static function removeItem($userId, $gameId)
{
    $pdo = Database::getConnection();

    // Opcional: habilitar exceções PDO temporariamente (bom para debug)
    $oldMode = $pdo->getAttribute(PDO::ATTR_ERRMODE);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    try {
        $stmt = $pdo->prepare("DELETE FROM cart WHERE id_usuario = ? AND id_jogo = ?");
        $stmt->execute([$userId, $gameId]);

        $rows = $stmt->rowCount();

        // volta o modo anterior
        $pdo->setAttribute(PDO::ATTR_ERRMODE, $oldMode);

        // retorna quantas linhas foram afetadas (0 = nada foi removido)
        return $rows;
    } catch (PDOException $e) {
        // volta o modo anterior
        $pdo->setAttribute(PDO::ATTR_ERRMODE, $oldMode);

        // Em dev, é útil lançar ou retornar a mensagem de erro
        // throw $e; // descomente se quiser que o erro apareça
        return [
            'error' => true,
            'message' => $e->getMessage()
        ];
    }
}


    /**
     * Limpa completamente o carrinho do usuário (opcional)
     */
    public static function clearCart($userId)
    {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("DELETE FROM cart WHERE id_usuario = ?");
        return $stmt->execute([$userId]);
    }
}
