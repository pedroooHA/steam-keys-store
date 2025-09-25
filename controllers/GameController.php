<?php
class GameController {
    public function list(){
        $categoryId = $_GET['category_id'] ?? null;

        if($categoryId){
            $games = Game::findByCategory($categoryId);
            $category = Category::findById($categoryId);
        } else {
            $games = Game::all();
            $category = null;
        }

        require __DIR__ . '/../views/games/list.php';
    }

    public function showCreate(){
        $this->authorize();
        $categories = Category::all();
        require __DIR__ . '/../views/games/create.php';
    }

    public function create(){
        $this->authorize();
        $g = new Game();
        $g->setTitle($_POST['title'] ?? '');
        $g->setPrice($_POST['price'] ?? 0);
        $g->setCategoryId($_POST['category_id'] ?? null);
        $g->setSteamKey($_POST['steam_key'] ?? '');
        $g->setDescription($_POST['description'] ?? '');
        $g->save();
        header('Location: index.php?route=games');
        exit;
    }

    private function authorize(){
        if(empty($_SESSION['user_id'])) {
            $_SESSION['flash'] = 'Faça login para acessar';
            header('Location: index.php?route=login');
            exit;
        }
    }

    public function view(){
        $id = $_GET['id'] ?? null;
        $game = Game::find($id);
        if(!$game){ echo 'Jogo não encontrado'; return; }
        require __DIR__ . '/../views/games/view.php';
    }
}
