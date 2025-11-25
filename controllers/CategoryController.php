<?php
class CategoryController {
    
    public function list(){
        $categories = Category::all();
        require __DIR__ . '/../views/categories/list.php';
    }
    
    public function create(){
        $this->authorize();
        
        $category = new Category();
        $category->setName($_POST['name'] ?? '');
        $category->save();
        
        header('Location: index.php?route=categories');
    }

    // Método para inserção em massa
    public function bulkCreate(){
        $this->authorize();
        
        // Configurar header para JSON
        header('Content-Type: application/json');
        
        // Verificar se é uma requisição POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode([
                'success' => false,
                'message' => 'Método não permitido'
            ]);
            exit;
        }

        try {
            $categoriesList = trim($_POST['categories_list'] ?? '');
            
            if (empty($categoriesList)) {
                throw new Exception('Lista de categorias vazia');
            }
            
            // Processar a lista de categorias
            $categoriesArray = explode("\n", $categoriesList);
            $categoriesArray = array_map('trim', $categoriesArray);
            $categoriesArray = array_filter($categoriesArray);
            
            if (empty($categoriesArray)) {
                throw new Exception('Nenhuma categoria válida encontrada');
            }
            
            $inserted = 0;
            $skipped = 0;
            $newCategories = [];
            
            foreach ($categoriesArray as $categoryName) {
                // Verificar se a categoria já existe
                $existingCategory = Category::findByName($categoryName);
                
                if (!$existingCategory) {
                    // Criar nova categoria
                    $newCategoryId = Category::create($categoryName);
                    $inserted++;
                    $newCategories[] = [
                        'id' => $newCategoryId,
                        'name' => $categoryName
                    ];
                } else {
                    $skipped++;
                }
            }
            
            // Retornar sucesso
            echo json_encode([
                'success' => true,
                'message' => "✅ Sucesso! $inserted novas categorias adicionadas. $skipped categorias já existiam e foram ignoradas.",
                'inserted' => $inserted,
                'skipped' => $skipped,
                'newCategories' => $newCategories
            ]);
            
        } catch (Exception $e) {
            // Retornar erro
            echo json_encode([
                'success' => false,
                'message' => '❌ Erro: ' . $e->getMessage()
            ]);
        }
        exit;
    }
    
    // Método para API - retornar todas as categorias em JSON
    public function getAll() {
        header('Content-Type: application/json');
        $categories = Category::all();
        
        $categoriesArray = [];
        foreach ($categories as $category) {
            $categoriesArray[] = [
                'id' => $category->getId(),
                'name' => $category->getName()
            ];
        }
        
        echo json_encode($categoriesArray);
        exit;
    }
    
    private function authorize(){
        if(empty($_SESSION['user_id'])) {
            $_SESSION['flash'] = 'Faça login para acessar';
            header('Location: index.php?route=login');
            exit;
        }
    }
}