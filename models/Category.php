<?php
class Category {
    private $id;
    private $name;

    // Getters e Setters
    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = trim($name);
        return $this;
    }

    // Método para salvar (inserir ou atualizar)
    public function save() {
        $db = Database::getConnection();
        
        if ($this->id) {
            // Update
            $stmt = $db->prepare("UPDATE categories SET name = ? WHERE id = ?");
            $stmt->execute([$this->name, $this->id]);
        } else {
            // Insert
            $stmt = $db->prepare("INSERT INTO categories (name) VALUES (?)");
            $stmt->execute([$this->name]);
            $this->id = $db->lastInsertId();
        }
        
        return $this;
    }

    // Método para deletar
    public function delete() {
        if (!$this->id) {
            throw new Exception("Categoria não possui ID");
        }
        
        $db = Database::getConnection();
        $stmt = $db->prepare("DELETE FROM categories WHERE id = ?");
        return $stmt->execute([$this->id]);
    }

    // ========== MÉTODOS ESTÁTICOS ==========

    // Buscar categoria por ID
    public static function findById($id) {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT * FROM categories WHERE id = ?");
        $stmt->execute([$id]);
        
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($data) {
            return self::createFromArray($data);
        }
        return null;
    }

    // Buscar categoria por nome
    public static function findByName($name) {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT * FROM categories WHERE name = ?");
        $stmt->execute([trim($name)]);
        
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($data) {
            return self::createFromArray($data);
        }
        return null;
    }

    // Buscar todas as categorias
    public static function all() {
        $db = Database::getConnection();
        $stmt = $db->query("SELECT * FROM categories ORDER BY name");
        $categories = [];
        
        while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $categories[] = self::createFromArray($data);
        }
        
        return $categories;
    }

    // Criar categoria diretamente (para bulk create)
    public static function create($name) {
        $category = new self();
        $category->setName($name);
        $category->save();
        return $category->getId();
    }

    // Contar total de categorias
    public static function count() {
        $db = Database::getConnection();
        $stmt = $db->query("SELECT COUNT(*) as total FROM categories");
        return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }

    // Buscar categorias com paginação
    public static function paginate($page = 1, $perPage = 10) {
        $db = Database::getConnection();
        $offset = ($page - 1) * $perPage;
        
        $stmt = $db->prepare("SELECT * FROM categories ORDER BY name LIMIT :limit OFFSET :offset");
        $stmt->bindValue(':limit', (int)$perPage, PDO::PARAM_INT);
        $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
        $stmt->execute();
        
        $categories = [];
        while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $categories[] = self::createFromArray($data);
        }
        
        return $categories;
    }

    // Verificar se categoria existe
    public static function exists($id) {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT COUNT(*) as count FROM categories WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC)['count'] > 0;
    }

    // ========== MÉTODOS PRIVADOS ==========

    // Criar objeto a partir de array
    private static function createFromArray($data) {
        $category = new self();
        $category->setId($data['id'])
                 ->setName($data['name']);
        return $category;
    }
}