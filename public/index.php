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

    // HOME
    case 'home':
        $c = new HomeController();
        $c->index();
        break;

    // LOGIN
    case 'login':
        $c = new AuthController();
        if($method === 'POST') $c->login();
        else $c->showLogin();
        break;

    // REGISTER
    case 'register':
        $c = new AuthController();
        if($method === 'POST') $c->register();
        else $c->showRegister();
        break;

    // LOGOUT
    case 'logout':
        $c = new AuthController();
        $c->logout();
        break;

    // GAMES
    case 'games':
        $c = new GameController();
        $action = $_GET['action'] ?? 'list';

        if (in_array($action, ['create'])) requireAdmin();

        if ($action === 'create' && $method === 'POST') $c->create();
        elseif ($action === 'create') $c->showCreate();
        elseif ($action === 'list') $c->list();
        elseif ($action === 'view') $c->view();
        else $c->list();
        break;

    // CATEGORIES
    case 'categories':
        $c = new CategoryController();
        requireAdmin();

        $action = $_GET['action'] ?? 'list';
        if ($action === 'create' && $method === 'POST') $c->create();
        elseif ($action === 'bulkCreate' && $method === 'POST') $c->bulkCreate();
        elseif ($action === 'getAll') $c->getAll();
        else $c->list();
        break;

    // CARRINHO
    case 'cart':
        $c = new CartController();
        $action = $_POST['action'] ?? $_GET['action'] ?? 'show';

        if ($action === 'add' && $method === 'POST') $c->add();
        elseif ($action === 'remove') $c->remove();
        else $c->show();
        break;

    // WISHLIST
    case 'wishlist':
        $c = new WishlistController();
        $action = $_POST['action'] ?? $_GET['action'] ?? 'show';
        
        if ($action === 'add' && $method === 'POST') $c->add();
        elseif ($action === 'remove') $c->remove();
        else $c->show();
        break;

    // PAYMENT
    case 'payment':
        $c = new PaymentController();
        $action = $_GET['action'] ?? 'process';

        if ($action === 'finish') {
            $c->finalizePurchase();  // REDUZ ESTOQUE AQUI
        } elseif (method_exists($c, $action)) {
            $c->$action();
        } else {
            echo "Ação inválida.";
        }
        break;

    // ADMIN
    case 'admin':
        requireAdmin();
        $c = new AdminController();
        $action = $_GET['action'] ?? 'dashboard';

        if ($action === 'dashboard') $c->dashboard();
        elseif ($action === 'users') $c->showUsers();
        elseif ($action === 'edit_user') $c->editUser();
        elseif ($action === 'delete_user') $c->deleteUser();
        elseif ($action === 'add-game' && $method === 'POST') $c->addGame();
        elseif ($action === 'add-game') $c->showAddGame();
        elseif ($action === 'reports') $c->showReports();
        else $c->dashboard();
        break;

    // 404
    default:
        http_response_code(404);
        echo 'Página não encontrada';
        break;
}
?>
