<?php
class Category {
    private $id;
    private $name;

    public function __construct($data = []) {
        $this->id = $data['id'] ?? null;
        $this->name = $data['name'] ?? null;
    }

    // getters e setters
    public function getId(){ return $this->id; }
    public function getName(){ return $this->name; }
    public function setName($v){ $this->name = $v; }

    // persistência
    public function save(){
        $pdo = db();
        if($this->id){
            $stmt = $pdo->prepare('UPDATE categories SET name=? WHERE id=?');
            $stmt->execute([$this->name, $this->id]);
        } else {
            $stmt = $pdo->prepare('INSERT INTO categories (name) VALUES (?)');
            $stmt->execute([$this->name]);
            $this->id = $pdo->lastInsertId();
        }
    }

    public static function all(){
        $pdo = db();
        $stmt = $pdo->query('SELECT * FROM categories ORDER BY name');
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $categories = [];
        foreach($results as $row){
            $categories[] = new Category($row);
        }
        return $categories;
    }

    // 🔹 Novo método: buscar categoria por ID
    public static function findById($id){
        $pdo = db();
        $stmt = $pdo->prepare('SELECT * FROM categories WHERE id = ?');
        $stmt->execute([$id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        return $data ? new Category($data) : null;
    }
}
