<?php

class HomeController {

    public function index() {
        
        $search = $_GET['search'] ?? '';
        
        
        error_log("Search term: " . $search);
        
        if (!empty($search)) {
            // Se há busca, filtra os jogos
            $games = $this->searchGames($search);
        } else {
            // Se não há busca, busca TODOS os jogos
            $games = Game::all();
        }

        error_log("Games found: " . count($games));
        
        // Envia as variáveis para a view
        require_once dirname(__DIR__) . '/views/home.php';
    }
    
    private function searchGames($searchTerm) {
        $pdo = Database::getConnection();
        
        $sql = "SELECT g.*, c.name as category_name 
                FROM games g 
                LEFT JOIN categories c ON g.category_id = c.id 
                WHERE LOWER(g.title) LIKE LOWER(:search) 
                ORDER BY g.title";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':search' => '%' . $searchTerm . '%']);
        
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        error_log("Search SQL: " . $sql);
        error_log("Search term used: " . $searchTerm);
        error_log("Results count: " . count($results));
        
        return $results;
    }
}