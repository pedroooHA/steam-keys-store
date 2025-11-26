<?php
class CategoryController {
    
    public function list(){
        $categories = Category::all();
        require __DIR__ . '/../views/categories/list.php';
    }
    
    public function create(){
        $this->authorize();
        
        $category = new Category();
        $category->setName(trim($_POST['name'] ?? ''));
        
        if (empty($category->getName())) {
            $_SESSION['flash'] = 'Nome da categoria é obrigatório';
            header('Location: index.php?route=categories');
            exit;
        }
        
        $category->save();
        header('Location: index.php?route=categories');
    }

    // 👇 MÉTODO BULKCREATE CORRIGIDO
    public function bulkCreate(){
        $this->authorize();
        header('Content-Type: application/json');
        
        try {
            // Ler dados JSON
            $input = json_decode(file_get_contents('php://input'), true);
            
            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new Exception('Dados JSON inválidos');
            }
            
            $categoriesArray = $input['categories'] ?? [];
            
            if (empty($categoriesArray)) {
                throw new Exception('Nenhuma categoria recebida');
            }
            
            // Processar categorias
            $categoriesArray = array_map('trim', $categoriesArray);
            $categoriesArray = array_filter($categoriesArray);
            
            if (empty($categoriesArray)) {
                throw new Exception('Nenhuma categoria válida encontrada');
            }
            
            $inserted = 0;
            $skipped = 0;
            $newCategories = [];
            
            foreach ($categoriesArray as $categoryName) {
                if (empty($categoryName)) continue;
                
                // Verificar se já existe
                if (!Category::exists($categoryName)) {
                    $category = new Category();
                    $category->setName($categoryName);
                    $categoryId = $category->save();
                    
                    $inserted++;
                    $newCategories[] = [
                        'id' => $categoryId,
                        'name' => $categoryName
                    ];
                } else {
                    $skipped++;
                }
            }
            
            echo json_encode([
                'success' => true,
                'message' => "✅ Sucesso! $inserted categorias adicionadas. $skipped já existiam.",
                'inserted' => $inserted,
                'skipped' => $skipped,
                'newCategories' => $newCategories
            ]);
            
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode([
                'success' => false,
                'message' => '❌ Erro: ' . $e->getMessage()
            ]);
        }
        exit;
    }
    
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
    
    private function authorize() {
        if (empty($_SESSION['user_id'])) {
            $_SESSION['flash'] = 'Faça login para acessar';
            header('Location: index.php?route=login');
            exit;
        }
    }
}
?>