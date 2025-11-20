<?php

class Category {
    private $id;
    private $name;

    // Construtor, getters e setters podem ser mantidos.
    public function __construct($data = []) {
        $this->id = $data['id'] ?? null;
        $this->name = $data['name'] ?? null;
    }

    public function getId(){ return $this->id; }
    public function getName(){ return $this->name; }
    public function setName($v){ $this->name = $v; }

    // --- MÉTODOS DE BANCO DE DADOS CORRIGIDOS ---

    public static function all() {
        $pdo = Database::getConnection(); // <-- CORRIGIDO
        $stmt = $pdo->query('SELECT * FROM categories ORDER BY name');
        return $stmt->fetchAll(PDO::FETCH_CLASS, 'Category');
    }

    public static function findById($id) {
        $pdo = Database::getConnection(); // <-- CORRIGIDO
        $stmt = $pdo->prepare('SELECT * FROM categories WHERE id = ?');
        $stmt->execute([$id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        return $data ? new Category($data) : null;
    }

    // --- NOVO MÉTODO: Encontrar por nome ---
    public static function findByName($name) {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare('SELECT * FROM categories WHERE name = ?');
        $stmt->execute([$name]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        return $data ? new Category($data) : null;
    }

    // --- NOVO MÉTODO: Criar categoria e retornar ID ---
    public static function create($name) {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare('INSERT INTO categories (name) VALUES (?)');
        $stmt->execute([$name]);
        return $pdo->lastInsertId();
    }

    public function save() {
        $pdo = Database::getConnection(); // <-- CORRIGIDO
        if ($this->id) {
            // Atualiza uma categoria existente
            $stmt = $pdo->prepare('UPDATE categories SET name=? WHERE id=?');
            $stmt->execute([$this->name, $this->id]);
        } else {
            // Insere uma nova categoria
            $stmt = $pdo->prepare('INSERT INTO categories (name) VALUES (?)');
            $stmt->execute([$this->name]);
            $this->id = $pdo->lastInsertId();
        }
    }
}