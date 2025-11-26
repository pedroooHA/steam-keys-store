<?php
class Game {
    private $id;
    private $title;
    private $price;
    private $category_id;
    private $steam_key;
    private $description;
    private $image;
    private $estoque;
    
    // Getters
    public function getId() { return $this->id; }
    public function getTitle() { return $this->title; }
    public function getPrice() { return $this->price; }
    public function getCategoryId() { return $this->category_id; }
    public function getSteamKey() { return $this->steam_key; }
    public function getDescription() { return $this->description; }
    public function getImage() { return $this->image; }
    public function getEstoque() { return $this->estoque; }
    
    // Setters
    public function setTitle($v) { $this->title = $v; }
    public function setPrice($v) { $this->price = floatval($v); }
    public function setCategoryId($v) { $this->category_id = $v ? intval($v) : null; }
    public function setSteamKey($v) { $this->steam_key = $v; }
    public function setDescription($v) { $this->description = $v; }
    public function setImage($v) { $this->image = $v; }
    public function setEstoque($v) { $this->estoque = intval($v); }

    // Métodos estáticos
    public static function all() {
        $pdo = Database::getConnection();
        $sql = "SELECT g.*, c.name as category_name 
                FROM games g 
                LEFT JOIN categories c ON g.category_id = c.id 
                ORDER BY g.title";
        $stmt = $pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function find($id) {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("SELECT g.*, c.name as category_name 
                              FROM games g 
                              LEFT JOIN categories c ON g.category_id = c.id 
                              WHERE g.id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    // 👇 MÉTODO SAVE COMPLETAMENTE CORRIGIDO - SEM change_type
    public function save() {
        $pdo = Database::getConnection();
        
        // 👇 APENAS OS CAMPOS QUE EXISTEM NA SUA TABELA
        $fields = [
            'title' => $this->title,
            'price' => $this->price,
            'category_id' => $this->category_id,
            'steam_key' => $this->steam_key,
            'description' => $this->description,
            'image' => $this->image,
            'estoque' => $this->estoque
        ];
        
        if ($this->id) {
            // UPDATE
            $sql = "UPDATE games SET 
                    title = :title, 
                    price = :price, 
                    category_id = :category_id, 
                    steam_key = :steam_key, 
                    description = :description, 
                    image = :image, 
                    estoque = :estoque 
                    WHERE id = :id";
            
            $fields['id'] = $this->id;
        } else {
            // INSERT
            $sql = "INSERT INTO games (title, price, category_id, steam_key, description, image, estoque) 
                    VALUES (:title, :price, :category_id, :steam_key, :description, :image, :estoque)";
        }
        
        try {
            $stmt = $pdo->prepare($sql);
            $result = $stmt->execute($fields);
            
            if ($result && !$this->id) {
                $this->id = $pdo->lastInsertId();
            }
            
            return $this->id;
            
        } catch (PDOException $e) {
            error_log("Database error in Game::save: " . $e->getMessage());
            throw new Exception("Erro ao salvar jogo: " . $e->getMessage());
        }
    }
    
    public static function findByIds(array $ids) {
        if (empty($ids)) return [];
        
        $pdo = Database::getConnection();
        $placeholders = str_repeat('?,', count($ids) - 1) . '?';
        $stmt = $pdo->prepare("SELECT * FROM games WHERE id IN ($placeholders)");
        $stmt->execute($ids);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>