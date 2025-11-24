<?php
// Inicia a sessão somente se ainda não estiver ativa
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Verifica se o usuário logado é admin
function isAdmin() {
    $user = getCurrentUser();
    return $user && $user->getRole() === 'admin';
}


// Redireciona se não for admin
function requireAdmin() {
    if (!isAdmin()) {
        header("Location: /?route=login");
        exit();
    }
}

// Verifica se o usuário está logado
function requireLogin() {
    if (!isset($_SESSION['user_id'])) {
        header("Location: /?route=login");
        exit();
    }
}

// Obtém o usuário atual
function getCurrentUser() {
    if (isset($_SESSION['user_id'])) {
        require_once __DIR__ . '/../models/User.php';
        return User::findById($_SESSION['user_id']);
    }
    return null;
}
?>