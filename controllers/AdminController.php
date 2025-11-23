<?php
class AdminController {
    public function dashboard() {
        requireAdmin(); // Usa sua função existente
        
        $user = getCurrentUser(); // Usa a nova função helper
        
        // Estatísticas
        $total_games = count(Game::all());
        $total_users = User::countAll();
        $total_categories = $this->getCategoriesCount();
        
        include __DIR__ . '/../views/admin/dashboard.php';
    }

    public function showUsers() {
        requireAdmin();
        
        $users = User::getAll();
        include __DIR__ . '/../views/admin/users.php';
    }

    public function showAddGame() {
        requireAdmin();

        $categories = $this->getAllCategories();
        include __DIR__ . '/../views/admin/add-game.php';
    }

    public function addGame() {
        requireAdmin();

        if ($_POST) {
            $game = new Game();
            $game->setTitle($_POST['title']);
            $game->setPrice($_POST['price']);
            $game->setCategoryId($_POST['category_id'] ?: null);
            $game->setSteamKey($_POST['steam_key']);
            $game->setDescription($_POST['description']);
            $game->setImage($_POST['image']);
            
            try {
                $game->save();
                $_SESSION['success'] = 'Jogo cadastrado com sucesso!';
                header('Location: /?route=admin&action=dashboard');
                exit;
            } catch (Exception $e) {
                $_SESSION['error'] = 'Erro ao cadastrar jogo: ' . $e->getMessage();
            }
        }

        header('Location: /?route=admin&action=add-game');
        exit;
    }

    public function showReports() {
        requireAdmin();
        
        include __DIR__ . '/../views/admin/reports.php';
    }

    private function getCategoriesCount() {
        $pdo = Database::getConnection();
        $stmt = $pdo->query("SELECT COUNT(*) as total FROM categories");
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'] ?? 0;
    }

    private function getAllCategories() {
        $pdo = Database::getConnection();
        $stmt = $pdo->query("SELECT * FROM categories ORDER BY name");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>