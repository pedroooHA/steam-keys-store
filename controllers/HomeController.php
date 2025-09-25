<?php
class HomeController {
    public function index(){
        $games = Game::all();
        require __DIR__ . '/../views/home.php';
    }
}
