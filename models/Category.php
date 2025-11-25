<?php

class Category {
    public $id;
    public $name;

    // Construtor para preencher os dados
    public function __construct($data = []) {
        $this->id   = $data['id']   ?? null;
        $this->name = $data['name'] ?? null;
    }

    public function getId()    { return $this->id; }
    public function getName()  { return $this->name; }
    public function setName($v){ $this->name = $v; }

    // --- PEGAR TODAS AS CATEGORIAS ---
    public static function all() {
        $pdo = Database::getConnection();
        $stmt = $pdo->query('SELECT * FROM categories ORDER BY id DESC');

        // ⚠️ AQUI ESTAVA O PROBLEMA:
        // PDO::FETCH_CLASS IGNORA O CONSTRUTOR
        // ENTÃO AGORA CRIAMOS O OBJETO MANUALMENTE
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $categories = [];

        foreach ($rows as $row) {
            $categories[] = new Category($row);
        }

        return $categories;
    }

    public static function findById($id) {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare('SELECT * FROM categories WHERE id = ?');
        $stmt->execute([$id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        return $data ? new Category($data) : null;
    }

    public static function findByName($name) {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare('SELECT * FROM categories WHERE name = ?');
        $stmt->execute([$name]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        return $data ? new Category($data) : null;
    }

    public static function create($name) {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare('INSERT INTO categories (name) VALUES (?)');
        $stmt->execute([$name]);
        return $pdo->lastInsertId();
    }

    public function save() {
        $pdo = Database::getConnection();
        if ($this->id) {
            // Atualizar categoria existente
            $stmt = $pdo->prepare('UPDATE categories SET name=? WHERE id=?');
            $stmt->execute([$this->name, $this->id]);
        } else {
            // Criar categoria nova
            $stmt = $pdo->prepare('INSERT INTO categories (name) VALUES (?)');
            $stmt->execute([$this->name]);
            $this->id = $pdo->lastInsertId();
        }
    }
}
