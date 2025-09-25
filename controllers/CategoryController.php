<?php
class CategoryController {
    public function list(){
        $categories = Category::all();
        require __DIR__ . '/../views/categories/list.php';
    }
    public function create(){
        $this->authorize();
        $c = new Category();
        $c->setName($_POST['name'] ?? '');
        $c->save();
        header('Location: index.php?route=categories');
    }
    private function authorize(){
        if(empty($_SESSION['user_id'])) {
            $_SESSION['flash'] = 'Faça login para acessar';
            header('Location: index.php?route=login');
            exit;
        }
    }
}
