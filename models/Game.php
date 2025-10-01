<?php

class Game {
    // Propriedades da classe
    private $id, $title, $price, $category_id, $steam_key, $description, $image;
    
    // Getters e Setters (Mantenha os seus se já os tiver)
    public function getId(){ return $this->id; }
    public function getTitle(){ return $this->title; }
    public function setTitle($v){ $this->title = $v; }
    public function getPrice(){ return $this->price; }
    public function setPrice($v){ $this->price = $v; }
    public function getCategoryId(){ return $this->category_id; }
    public function setCategoryId($v){ $this->category_id = $v; }
    public function getSteamKey(){ return $this->steam_key; }
    public function setSteamKey($v){ $this->steam_key = $v; }
    public function getDescription(){ return $this->description; }
    public function setDescription($v){ $this->description = $v; }
    public function getImage(){ return $this->image; }
    public function setImage($v){ $this->image = $v; }

    // --- MÉTODOS DE BANCO DE DADOS PADRONIZADOS ---

    public static function all() {
        $pdo = Database::getConnection();
        $sql = "SELECT g.*, c.name as category_name FROM games g LEFT JOIN categories c ON g.category_id = c.id ORDER BY g.title";
        return $pdo->query($sql)->fetchAll();
    }

    public static function find($id) {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("SELECT g.*, c.name as category_name FROM games g LEFT JOIN categories c ON g.category_id = c.id WHERE g.id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
    
    /**
     * Busca múltiplos jogos por seus IDs.
     * @param array $ids Array de IDs de jogos.
     * @return array Lista de jogos encontrados.
     */
    public static function findByIds(array $ids) // <-- Mantivemos apenas UMA versão desta função
    {
        if (empty($ids)) {
            return [];
        }
        $pdo = Database::getConnection();
        $placeholders = rtrim(str_repeat('?,', count($ids)), ',');
        $stmt = $pdo->prepare("SELECT * FROM games WHERE id IN ($placeholders)");
        $stmt->execute($ids);
        return $stmt->fetchAll();
    }
    
    public function save() {
        $pdo = Database::getConnection();
        if($this->id){
            $stmt = $pdo->prepare('UPDATE games SET title=?, price=?, category_id=?, steam_key=?, description=?, image=? WHERE id=?');
            $stmt->execute([$this->title, $this->price, $this->category_id, $this->steam_key, $this->description, $this->image, $this->id]);
        } else {
            $stmt = $pdo->prepare('INSERT INTO games (title, price, category_id, steam_key, description, image) VALUES (?, ?, ?, ?, ?, ?)');
            $stmt->execute([$this->title, $this->price, $this->category_id, $this->steam_key, $this->description, $this->image]);
            $this->id = $pdo->lastInsertId();
        }
    }
}