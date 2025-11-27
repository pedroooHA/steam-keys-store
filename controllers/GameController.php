<?php
class GameController {

    public function list() {
        $allGames = Game::all();
        
        $groupedGames = [];
        foreach ($allGames as $game) {
            $categoryName = $game['category_name'] ?? 'Sem Categoria';
            
            if (!isset($groupedGames[$categoryName])) {
                $groupedGames[$categoryName] = [];
            }
            
            $groupedGames[$categoryName][] = $game;
        }

        require __DIR__ . '/../views/games/list.php';
    }

    public function showCreate() {
        $this->authorize();
        $categories = Category::all();
        require __DIR__ . '/../views/games/create.php';
    }

    public function create() {
        $this->authorize();
        header('Content-Type: application/json');

        try {
            $g = new Game();
            $g->setTitle(trim($_POST['title'] ?? ''));
            $g->setPrice(floatval($_POST['price'] ?? 0));
            $g->setCategoryId($_POST['category_id'] ?? null);
            $g->setSteamKey(trim($_POST['steam_key'] ?? ''));
            $g->setDescription(trim($_POST['description'] ?? ''));
            $g->setEstoque(intval($_POST['estoque'] ?? 0));

            // Processar imagem
            $imageUrl = trim($_POST['image_url'] ?? '');
            $imageFile = $_FILES['image_upload'] ?? null;
            $imageToSave = null;

            if (!empty($imageUrl) && filter_var($imageUrl, FILTER_VALIDATE_URL)) {
                $imageToSave = $imageUrl;
            } else if ($imageFile && $imageFile['error'] === UPLOAD_ERR_OK) {
                $uploadDir = __DIR__ . '/../../public/uploads/';
                
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }
                
                $fileName = uniqid() . '-' . basename($imageFile['name']);
                $targetPath = $uploadDir . $fileName;

                if (move_uploaded_file($imageFile['tmp_name'], $targetPath)) {
                    $imageToSave = '/uploads/' . $fileName;
                }
            }

            $g->setImage($imageToSave);
            
            // Validações
            if (empty($g->getTitle())) {
                throw new Exception('Título do jogo é obrigatório.');
            }
            
            if ($g->getPrice() <= 0) {
                throw new Exception('Preço deve ser maior que zero.');
            }
            
            if (empty($g->getCategoryId())) {
                throw new Exception('Categoria é obrigatória.');
            }

            // 👇 DEBUG: Log antes de salvar
            error_log("🎯 Salvando jogo: " . $g->getTitle() . ", Preço: " . $g->getPrice() . ", Categoria: " . $g->getCategoryId());

            $gameId = $g->save();
            
            echo json_encode([
                'success' => true,
                'message' => 'Jogo adicionado com sucesso!',
                'game_id' => $gameId
            ]);

        } catch (Exception $e) {
            error_log("❌ Erro em GameController::create: " . $e->getMessage());
            http_response_code(400);
            echo json_encode([
                'success' => false,
                'message' => 'Erro: ' . $e->getMessage()
            ]);
        }
        exit;
    }

    public function view() {
        $id = $_GET['id'] ?? null;
        $game = Game::find($id);
        
        if (!$game) {
            echo 'Jogo não encontrado';
            return;
        }
        
        require __DIR__ . '/../views/games/view.php';
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