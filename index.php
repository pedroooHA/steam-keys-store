<?php
// Front controller - simple routing via ?route=

require_once __DIR__ . '/config/database.php';
spl_autoload_register(function($class){
    $path = __DIR__ . '/controllers/' . $class . '.php';
    if(file_exists($path)) require_once $path;
    $path = __DIR__ . '/models/' . $class . '.php';
    if(file_exists($path)) require_once $path;
});

session_start();

// 🔹 Importa o middleware de admin
require_once __DIR__ . '/helpers/auth.php';

$route = $_GET['route'] ?? 'home';
$method = $_SERVER['REQUEST_METHOD'];

switch($route){
    case 'home':
        $c = new HomeController();
        $c->index();
        break;

    case 'login':
        $c = new AuthController();
        if($method === 'POST') $c->login();
        else $c->showLogin();
        break;

    case 'register':
        $c = new AuthController();
        if($method === 'POST') $c->register();
        else $c->showRegister();
        break;

    case 'logout':
        $c = new AuthController();
        $c->logout();
        break;

    case 'games':
        $c = new GameController();
        $action = $_GET['action'] ?? 'list';

        // 🔹 Protege criação de jogos (apenas admin)
        if(in_array($action, ['create'])) {
            requireAdmin();
        }

        if($action === 'create' && $method === 'POST') $c->create();
        elseif($action === 'create') $c->showCreate();
        elseif($action === 'list') $c->list();
        elseif($action === 'view') $c->view();
        else $c->list();
        break;

    case 'categories':
        $c = new CategoryController();
        $action = $_GET['action'] ?? 'list';

        // 🔹 Protege criação de categorias (apenas admin)
        if($action === 'create') {
            requireAdmin();
        }

        if($action === 'create' && $method === 'POST') $c->create();
        else $c->list();
        break;

    default:
        http_response_code(404);
        echo 'Not Found';
}
