<?php
class AdminController {
    public function dashboard() {
        // Verificar se é admin
        if (empty($_SESSION['user_id'])) {
            header("Location: index.php?route=login");
            exit;
        }
        
        $user = User::findById($_SESSION['user_id']);
        if ($user->getRole() !== 'admin') { // ✅ CORRIGIDO
            header("Location: index.php");
            exit;
        }
        
        // Aqui você pode buscar estatísticas do banco
        include '../views/admin/dashboard.php';
    }
    
    public function showUsers() {
        // Verificar admin
        if (empty($_SESSION['user_id'])) {
            header("Location: index.php?route=login");
            exit;
        }
        
        $user = User::findById($_SESSION['user_id']);
        if ($user->getRole() !== 'admin') { // ✅ CORRIGIDO
            header("Location: index.php");
            exit;
        }
        
        // Buscar todos os usuários
        $users = User::getAll();
        include '../views/admin/users.php';
    }
    
    public function manageUsers() {
        // Lógica para gerenciar usuários (POST)
        // Implementar conforme necessidade
    }
    
    public function showAddGame() {
        // Verificar admin
        if (empty($_SESSION['user_id'])) {
            header("Location: index.php?route=login");
            exit;
        }
        
        $user = User::findById($_SESSION['user_id']);
        if ($user->getRole() !== 'admin') { // ✅ CORRIGIDO
            header("Location: index.php");
            exit;
        }
        
        include '../views/admin/add_game.php';
    }
    
    public function addGame() {
        // Lógica para adicionar jogo (POST)
        // Implementar conforme necessidade
    }
    
    public function showReports() {
        // Verificar admin
        if (empty($_SESSION['user_id'])) {
            header("Location: index.php?route=login");
            exit;
        }
        
        $user = User::findById($_SESSION['user_id']);
        if ($user->getRole() !== 'admin') { // ✅ CORRIGIDO
            header("Location: index.php");
            exit;
        }
        
        include '../views/admin/reports.php';
    }
}
?>