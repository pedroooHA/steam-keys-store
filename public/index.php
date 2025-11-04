<?php
// 1) Abrir sessão só se não existir
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


// 2) Config e helpers
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../helpers/auth.php';

// 3) Autoload para Models e Controllers
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

    // ✅ ROTA DO CARRINHO (única, limpa e funcional)
    case 'cart':
        $c = new CartController();
        $action = $_POST['action'] ?? $_GET['action'] ?? 'show';

        if ($action === 'add' && $method === 'POST') {
            $c->add();
        } elseif ($action === 'remove') {
            $c->remove();
        } else {
            $c->show();
        }
        break;

    case 'wishlist':
        $c = new WishlistController();
        $action = $_POST['action'] ?? $_GET['action'] ?? 'show';
        
        if ($action === 'add' && $method === 'POST') {
            $c->add();
        } elseif ($action === 'remove') {
            $c->remove();
        } else {
            $c->show();
        }
        break;

    default:
        http_response_code(404);
        echo 'Página não encontrada';
        break;
}
?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
/* Botão outline primário */
.btn-outline-primary {
    color: #ffffff !important;
    background-color: #000000ff !important;
    border-color: #000000ff !important;
    padding: 10px 18px !important;
    font-size: 16px !important;
    border-radius: 8px;
    transition: all 0.25s ease-in-out;
}

/* Efeito hover */
.btn-outline-primary:hover {
    background-color: #000000ff !important;
    border-color: #000000ff !important;
    color: #ffffff !important;
    transform: scale(1.05);
}

/* Botão do checkout */
.btn.btn-success.btn-lg.w-100.checkout-btn {
    background-color: #000000ff !important;
    border-color: #000000ff !important;
    color: #ffffff !important;
    padding: 12px 20px !important;
    font-size: 18px !important;
    border-radius: 8px;
    transition: all 0.25s ease-in-out;
}

.btn.btn-success.btn-lg.w-100.checkout-btn:hover {
    transform: scale(1.05);
}
</style>
