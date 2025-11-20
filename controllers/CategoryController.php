<?php
class CategoryController {
    public function list(){
        $categories = Category::all();
        require __DIR__ . '/../views/categories/list.php';
    }
    
    public function create(){
        $this->authorize();
        $c = new Category();
        $c->setName($_POST['name'] ?? '');
        $c->save();
        header('Location: index.php?route=categories');
    }

    // --- NOVO MÉTODO: Inserção em massa ---
    public function bulkCreate(){
        $this->authorize();
        
        // Verificar se é uma requisição POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['categories_list'])) {
            
            // Configurar header para JSON
            header('Content-Type: application/json');
            
            try {
                $categoriesList = trim($_POST['categories_list']);
                $categoriesArray = array_filter(array_map('trim', explode("\n", $categoriesList)));
                
                $inserted = 0;
                $skipped = 0;
                $newCategories = [];
                
                foreach ($categoriesArray as $categoryName) {
                    if (empty($categoryName)) continue;
                    
                    // Verificar se a categoria já existe
                    $existingCategory = Category::findByName($categoryName);
                    
                    if (!$existingCategory) {
                        // Inserir nova categoria
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
                    'message' => "Sucesso! $inserted novas categorias adicionadas. $skipped já existiam.",
                    'inserted' => $inserted,
                    'skipped' => $skipped,
                    'newCategories' => $newCategories
                ]);
                
            } catch (Exception $e) {
                // Retornar erro
                echo json_encode([
                    'success' => false,
                    'message' => 'Erro: ' . $e->getMessage()
                ]);
            }
        } else {
            // Se não for POST, retornar erro
            echo json_encode([
                'success' => false,
                'message' => 'Método não permitido'
            ]);
        }
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