<?php
// search_ajax.php
header('Content-Type: application/json');

$searchTerm = $_GET['q'] ?? '';
$searchTerm = trim($searchTerm);

if (empty($searchTerm)) {
    echo json_encode([]);
    exit;
}


$host = 'localhost';
$dbname = 'steam_keys_store';   
$username = 'root'; 
$password = '';   

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Busca na tabela games
    $stmt = $pdo->prepare("SELECT id, title, price, image FROM games WHERE title LIKE :search OR description LIKE :search ORDER BY title LIMIT 8");
    $stmt->execute(['search' => "%$searchTerm%"]);
    $games = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo json_encode($games);
    
} catch (PDOException $e) {
    echo json_encode(['error' => 'Erro na pesquisa']);
}
?>