<?php
class Game {
    private $id;
    private $title;
    private $price;
    private $category_id;
    private $steam_key;
    private $description;
    private $image; // nova propriedade para imagem

    public function __construct($data = []) {
        $this->id = $data['id'] ?? null;
        $this->title = $data['title'] ?? null;
        $this->price = $data['price'] ?? null;
        $this->category_id = $data['category_id'] ?? null;
        $this->steam_key = $data['steam_key'] ?? null;
        $this->description = $data['description'] ?? null;
        $this->image = $data['image'] ?? null;
    }

    // getters e setters
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

    // salvar/atualizar
    public function save(){
        $pdo = db();
        if($this->id){
            $stmt = $pdo->prepare('UPDATE games SET title=?, price=?, category_id=?, steam_key=?, description=?, image=? WHERE id=?');
            $stmt->execute([$this->title, $this->price, $this->category_id, $this->steam_key, $this->description, $this->image, $this->id]);
        } else {
            $stmt = $pdo->prepare('INSERT INTO games (title, price, category_id, steam_key, description, image) VALUES (?, ?, ?, ?, ?, ?)');
            $stmt->execute([$this->title, $this->price, $this->category_id, $this->steam_key, $this->description, $this->image]);
            $this->id = $pdo->lastInsertId();
        }
    }

    // todos os jogos
    public static function all(){
        $pdo = db();
        $stmt = $pdo->query('SELECT g.*, c.name as category_name FROM games g LEFT JOIN categories c ON g.category_id = c.id ORDER BY g.title');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // buscar jogo por id
    public static function find($id){
        $pdo = db();
        $stmt = $pdo->prepare('SELECT g.*, c.name as category_name FROM games g LEFT JOIN categories c ON g.category_id = c.id WHERE g.id = ?');
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // buscar jogos por categoria
    public static function findByCategory($categoryId){
        $pdo = db();
        $stmt = $pdo->prepare('
            SELECT g.*, c.name as category_name
            FROM games g
            LEFT JOIN categories c ON g.category_id = c.id
            WHERE g.category_id = ?
            ORDER BY g.title
        ');
        $stmt->execute([$categoryId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
