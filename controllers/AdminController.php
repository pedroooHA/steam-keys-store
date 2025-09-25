<?php
require_once 'models/Game.php';
require_once 'models/Category.php';

class AdminController {
    public function index() {
        requireAdmin(); // só admin pode acessar
        require 'views/admin/dashboard.php';
    }

    public function createGame() {
        requireAdmin();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $game = new Game();
            $game->setTitle($_POST['title']);
            $game->setPrice($_POST['price']);
            $game->setCategoryId($_POST['category_id']);
            $game->save();
            header("Location: index.php?controller=admin&action=index");
        } else {
            $categories = Category::getAll();
            require 'views/admin/create_game.php';
        }
    }
}
