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

    // --------- GETTERS --------- //
    public function getId() { return $this->id; }
    public function getTitle() { return $this->title; }
    public function getPrice() { return $this->price; }
    public function getCategoryId() { return $this->category_id; }
    public function getSteamKey() { return $this->steam_key; }
    public function getDescription() { return $this->description; }
    public function getImage() { return $this->image; }
    public function getEstoque() { return $this->estoque; }

    // --------- SETTERS --------- //
    public function setTitle($v) { $this->title = $v; }
    public function setPrice($v) { $this->price = floatval($v); }
    public function setCategoryId($v) { $this->category_id = $v ? intval($v) : null; }
    public function setSteamKey($v) { $this->steam_key = $v; }
    public function setDescription($v) { $this->description = $v; }
    public function setImage($v) { $this->image = $v; }
    public function setEstoque($v) { $this->estoque = intval($v); }

    // --------- LISTAR TODOS --------- //
    public static function all() {
        $pdo = Database::getConnection();
        $sql = "SELECT g.*, c.name as category_name 
                FROM games g 
                LEFT JOIN categories c ON g.category_id = c.id 
                ORDER BY g.title";
        $stmt = $pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // --------- REDUZIR ESTOQUE --------- //
    public static function reduzirEstoque($id, $quantidade)
    {
        $db = Database::getConnection();
        $stmt = $db->prepare("UPDATE games SET estoque = estoque - :qtd WHERE id = :id AND estoque >= :qtd");
        $stmt->bindValue(':qtd', $quantidade, PDO::PARAM_INT);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->rowCount() > 0;
    }

    // --------- FIND --------- //
    public static function find($id) {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("SELECT g.*, c.name as category_name 
                              FROM games g 
                              LEFT JOIN categories c ON g.category_id = c.id 
                              WHERE g.id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // --------- SAVE --------- //
    public function save() {
        $pdo = Database::getConnection();
        
        if ($this->id) {
            $stmt = $pdo->prepare('UPDATE games SET title=?, price=?, category_id=?, steam_key=?, description=?, image=?, estoque=? WHERE id=?');
            return $stmt->execute([
                $this->title, 
                $this->price, 
                $this->category_id, 
                $this->steam_key, 
                $this->description, 
                $this->image, 
                $this->estoque, 
                $this->id
            ]) ? $this->id : false;
        } else {
            $stmt = $pdo->prepare('INSERT INTO games (title, price, category_id, steam_key, description, image, estoque) VALUES (?, ?, ?, ?, ?, ?, ?)');
            if ($stmt->execute([
                $this->title, 
                $this->price, 
                $this->category_id, 
                $this->steam_key, 
                $this->description, 
                $this->image, 
                $this->estoque
            ])) {
                $this->id = $pdo->lastInsertId();
                return $this->id;
            }
            return false;
        }
    }
}
?>