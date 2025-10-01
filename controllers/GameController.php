<?php
class GameController {

    public function list(){
        // 1. Buscamos TODOS os jogos do banco de dados.
        // A lógica de filtrar por uma categoria específica foi removida daqui,
        // pois a nova view exibe todas as categorias de uma vez.
        $allGames = Game::all();

        // 2. Criamos um novo array para agrupar os jogos por categoria.
        $groupedGames = [];
        foreach ($allGames as $game) {
            // Usamos o nome da categoria como "chave" do nosso novo array.
            $categoryName = $game['category_name'] ?? 'Sem Categoria';
            
            // Se a categoria ainda não existe no array, nós a criamos.
            if (!isset($groupedGames[$categoryName])) {
                $groupedGames[$categoryName] = [];
            }
            
            // Adicionamos o jogo atual dentro de sua respectiva categoria.
            $groupedGames[$categoryName][] = $game;
        }

        // 3. Enviamos o novo array '$groupedGames' para a view.
        // É importante que sua view agora use a variável '$groupedGames' no loop.
        require __DIR__ . '/../views/games/list.php';
    }

    public function showCreate(){
        $this->authorize();
        $categories = Category::all();
        require __DIR__ . '/../views/games/create.php';
    }

    // 👇 MÉTODO CREATE COMPLETAMENTE ATUALIZADO 👇
    public function create()
    {
        $this->authorize(); // Garante que apenas usuários autorizados possam criar jogos

        $g = new Game();
        $g->setTitle($_POST['title'] ?? '');
        $g->setPrice($_POST['price'] ?? 0);
        $g->setCategoryId($_POST['category_id'] ?? null);
        $g->setSteamKey($_POST['steam_key'] ?? '');
        $g->setDescription($_POST['description'] ?? '');

        // --- NOVA LÓGICA PARA LIDAR COM A IMAGEM HÍBRIDA ---
        
        $imageUrl = trim($_POST['image_url'] ?? '');
        $imageFile = $_FILES['image_file'] ?? null;
        $imageToSave = null; // Variável que guardará o valor final para o banco

        // 1. Prioridade 1: Verifica se um link válido foi enviado.
        if (!empty($imageUrl) && filter_var($imageUrl, FILTER_VALIDATE_URL)) {
            $imageToSave = $imageUrl;
        } 
        // 2. Prioridade 2: Se não houver link, verifica se um arquivo foi enviado.
        else if ($imageFile && $imageFile['error'] === UPLOAD_ERR_OK) {
            
            // Define o diretório de uploads (geralmente dentro de uma pasta 'public')
            $uploadDir = __DIR__ . '/../../public/uploads/';
            
            // Cria a pasta se ela não existir
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            
            // Gera um nome de arquivo único para evitar sobreposição
            $fileName = uniqid() . '-' . basename($imageFile['name']);
            $targetPath = $uploadDir . $fileName;

            // Move o arquivo temporário para o diretório final
            if (move_uploaded_file($imageFile['tmp_name'], $targetPath)) {
                $imageToSave = $fileName; // Salva apenas o nome do arquivo no banco
            }
        }

        // Define a imagem no objeto do jogo (seja o link ou o nome do arquivo)
        $g->setImage($imageToSave);
        
        // --- FIM DA NOVA LÓGICA ---

        $g->save();
        
        // Redireciona para a lista de jogos após salvar
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

