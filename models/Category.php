<?php
class Category {
    private $id;
    private $name;
    
    // Getters
    public function getId() { return $this->id; }
    public function getName() { return $this->name; }
    
    // Setters
    public function setName($v) { $this->name = $v; }
    
    // Métodos estáticos
    public static function all() {
        $pdo = Database::getConnection();
        $stmt = $pdo->query("SELECT * FROM categories ORDER BY name");
        
        $categories = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $category = new Category();
            $category->id = $row['id'];
            $category->name = $row['name'];
            $categories[] = $category;
        }
        return $categories;
    }
    
    public static function find($id) {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("SELECT * FROM categories WHERE id = ?");
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($row) {
            $category = new Category();
            $category->id = $row['id'];
            $category->name = $row['name'];
            return $category;
        }
        return null;
    }
    
    public static function findByName($name) {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("SELECT * FROM categories WHERE name = ?");
        $stmt->execute([$name]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public static function exists($name) {
        return self::findByName($name) !== false;
    }
    
    // Salvar no banco
    public function save() {
        $pdo = Database::getConnection();
        
        if (isset($this->id)) {
            // UPDATE
            $stmt = $pdo->prepare("UPDATE categories SET name = ? WHERE id = ?");
            $stmt->execute([$this->name, $this->id]);
            return $this->id;
        } else {
            // INSERT
            $stmt = $pdo->prepare("INSERT INTO categories (name) VALUES (?)");
            $stmt->execute([$this->name]);
            $this->id = $pdo->lastInsertId();
            return $this->id;
        }
    }
}
?>