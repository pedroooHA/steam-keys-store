<?php
// 1) Abrir sessão só se não existir
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 2) Config e helpers
// Carrega a classe de conexão e funções de ajuda
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../helpers/auth.php';

// 3) Autoload para carregar Models e Controllers automaticamente
spl_autoload_register(function($class){
    $controllerPath = __DIR__ . '/../controllers/' . $class . '.php';
    $modelPath = __DIR__ . '/../models/' . $class . '.php';

    if (file_exists($controllerPath)) require_once $controllerPath;
    elseif (file_exists($modelPath)) require_once $modelPath;
});

// 4) Roteamento
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

        if($action === 'create') {
            requireAdmin();
        }

        if($action === 'create' && $method === 'POST') $c->create();
        else $c->list();
        break;


    // 👇 ROTA DO CARRINHO CORRIGIDA E NO LUGAR CERTO 👇
    case 'cart':
        $c = new CartController();
        $action = $_POST['action'] ?? $_GET['action'] ?? 'show';
        if ($action === 'add' && $method === 'POST') {
            $c->add();
        } else {
            $c->show();
        }
        break;

    default:
        http_response_code(404);
        // O ideal é ter uma view para a página 404
        echo 'Página não encontrada';
        break;

        case 'cart':
    $c = new CartController();
    $action = $_GET['action'] ?? 'show'; // Prioriza GET para ações como 'remove'

    if ($action === 'add' && $_SERVER['REQUEST_METHOD'] === 'POST') {
        $c->add();
    } elseif ($action === 'remove') { // <-- ADICIONE ESTA CONDIÇÃO
        $c->remove();
    } else {
        $c->show();
    }
    break;
}
