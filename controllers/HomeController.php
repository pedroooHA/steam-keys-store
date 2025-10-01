<?php

class HomeController {

    public function index() {
        // 1. Simplesmente busca TODOS os jogos do banco, sem agrupar.
        $games = Game::all();

        // 2. Envia a variável '$games' (e não '$groupedGames') para a view.
        require_once dirname(__DIR__) . '/views/home.php';
    }
}