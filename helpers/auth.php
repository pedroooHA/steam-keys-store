<?php
// Inicia a sessão somente se ainda não estiver ativa
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Verifica se o usuário logado é admin
function isAdmin() {
    return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
}

// Redireciona se não for admin
function requireAdmin() {
    if (!isAdmin()) {
        header("Location: index.php?controller=auth&action=login");
        exit();
    }
}
