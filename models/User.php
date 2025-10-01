<?php

class User {
    private $id;
    private $name;
    private $email;
    private $password_hash;
    private $role;

    // Construtor e Getters/Setters (Mantenha como estão)
    public function __construct($data = []) {
        if($data){
            $this->id = $data['id'] ?? null;
            $this->name = $data['name'] ?? null;
            $this->email = $data['email'] ?? null;
            $this->password_hash = $data['password_hash'] ?? null;
            $this->role = $data['role'] ?? 'user';
        }
    }

    public function getId(){ return $this->id; }
    public function getName(){ return $this->name; }
    public function setName($v){ $this->name = $v; }
    public function getEmail(){ return $this->email; }
    public function setEmail($v){ $this->email = $v; }
    public function getPasswordHash(){ return $this->password_hash; }
    public function setPasswordHash($v){ $this->password_hash = $v; }
    public function getRole(){ return $this->role; }
    public function setRole($role){ $this->role = $role; }
    
    // --- MÉTODOS DE BANCO DE DADOS CORRIGIDOS ---

    public function save() {
        $pdo = Database::getConnection(); // <-- CORRIGIDO
        if ($this->id) {
            $stmt = $pdo->prepare('UPDATE users SET name = ?, email = ?, password_hash = ?, role = ? WHERE id = ?');
            $stmt->execute([$this->name, $this->email, $this->password_hash, $this->role, $this->id]);
        } else {
            $stmt = $pdo->prepare('INSERT INTO users (name, email, password_hash, role) VALUES (?, ?, ?, ?)');
            $stmt->execute([$this->name, $this->email, $this->password_hash, $this->role]);
            $this->id = $pdo->lastInsertId();
        }
    }

    public static function findByEmail($email) {
        $pdo = Database::getConnection(); // <-- CORRIGIDO
        $stmt = $pdo->prepare('SELECT * FROM users WHERE email = ?');
        $stmt->execute([$email]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        return $data ? new User($data) : null;
    }

    public static function findById($id) {
        $pdo = Database::getConnection(); // <-- CORRIGIDO
        $stmt = $pdo->prepare('SELECT * FROM users WHERE id = ?');
        $stmt->execute([$id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        // Retorna um objeto User se encontrar, senão null
        return $data ? new User($data) : null;
    }
}