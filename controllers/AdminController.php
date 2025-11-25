<?php
class AdminController {
    public function dashboard() {
        requireAdmin();
        
        $user = getCurrentUser();
        
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

    public function editUser() {
        requireAdmin();
        
        $userId = $_GET['id'] ?? null;
        if (!$userId) {
            $_SESSION['error'] = 'ID do usuário não especificado';
            header('Location: ?route=admin&action=users');
            exit;
        }
        
        $user = User::findById($userId);
        if (!$user) {
            $_SESSION['error'] = 'Usuário não encontrado';
            header('Location: ?route=admin&action=users');
            exit;
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $user->setName($_POST['name']);
                $user->setEmail($_POST['email']);
                $user->setRole($_POST['role']);
                
                $user->update();
                $_SESSION['success'] = 'Usuário atualizado com sucesso!';
                header('Location: ?route=admin&action=users');
                exit;
            } catch (Exception $e) {
                $_SESSION['error'] = 'Erro ao atualizar usuário: ' . $e->getMessage();
            }
        }
        
        include __DIR__ . '/../views/admin/edit-user.php';
    }

    public function deleteUser() {
        requireAdmin();
        
        $userId = $_GET['id'] ?? null;
        if (!$userId) {
            $_SESSION['error'] = 'ID do usuário não especificado';
            header('Location: ?route=admin&action=users');
            exit;
        }
        
        // Impedir que o admin se delete
        $currentUser = getCurrentUser();
        if ($userId == $currentUser->getId()) {
            $_SESSION['error'] = "Você não pode excluir sua própria conta!";
            header('Location: ?route=admin&action=users');
            exit;
        }
        
        try {
            User::delete($userId);
            $_SESSION['success'] = 'Usuário excluído com sucesso!';
        } catch (Exception $e) {
            $_SESSION['error'] = 'Erro ao excluir usuário: ' . $e->getMessage();
        }
        
        header('Location: ?route=admin&action=users');
        exit;
    }

    public function showAddGame() {
        requireAdmin();

        $categories = $this->getAllCategories();
        include __DIR__ . '/../views/admin/add-game.php';
    }

    public function addGame() {
        requireAdmin();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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
                header('Location: ?route=admin&action=dashboard');
                exit;
            } catch (Exception $e) {
                $_SESSION['error'] = 'Erro ao cadastrar jogo: ' . $e->getMessage();
            }
        }

        header('Location: ?route=admin&action=add-game');
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