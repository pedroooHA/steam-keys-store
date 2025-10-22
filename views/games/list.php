<?php require __DIR__ . '/../layout/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Nossos Jogos</h1>
    <?php if (!empty($_SESSION['user_id']) && isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
        <a class="btn btn-primary" href="index.php?route=games&action=create">Adicionar jogo</a>
    <?php endif; ?>
</div>
    <?php
    // O loop de fora percorre as CATEGORIAS (ex: 'Ação', 'RPG')
    foreach ($groupedGames as $categoryName => $gamesInCategory):
    ?>

        <section class="category-section">
            <h2 class="category-title"><?php echo htmlentities($categoryName); ?></h2>

            <div class="games-row">
                <?php
                // O loop de dentro percorre os JOGOS de cada categoria
                foreach ($gamesInCategory as $game):
                    
                    // --- LÓGICA DA IMAGEM CORRIGIDA ---
$imagePath = htmlspecialchars($game['image'] ?? '');
// Verifica se o campo 'image' é um link completo.
if (filter_var($imagePath, FILTER_VALIDATE_URL)) {
    $imageUrl = $imagePath; // Se for um link válido, usa diretamente.
} else if (!empty($imagePath)) {
    $imageUrl = 'uploads/'. $imagePath; // Se não for URL, assume que está na pasta uploads/.
} else {
    $imageUrl = 'https://via.placeholder.com/280x150/1f2b57/a3b6e6?text=Sem+Imagem'; // Imagem padrão.
}
// --- FIM DA LÓGICA DA IMAGEM ---
                    
                ?>

                <img src="<?php echo $imageUrl; ?>" 
                 style="max-width: 280px; max-height: 150px; width: auto; height: auto;"
                  alt="Imagem do jogo"
                 onerror="this.src='https:via.placeholder.com/280x150/1f2b57/a3b6e6?text=Sem+Imagem'">

                    <a href="index.php?route=games&action=view&id=<?php echo $game['id']; ?>" class="card-link">
                        <div class="game-card">
                            <header class="card-header">
                                <img src="<?php echo $imageUrl; ?>" alt="<?php echo htmlspecialchars($game['title']); ?>" class="card-img">
                                
                                <div class="steam-tag">
                                    <i class="fa-brands fa-steam"></i> Steam
                                </div>
                            </header>
                            <div class="card-body">
                                <h3 class="card-title"><?php echo htmlspecialchars($game['title']); ?></h3>
                                
                                <?php // --- LÓGICA DE PREÇO COM DESCONTO (OPCIONAL) ---
                                // Verifica se existe informação de desconto para mostrar o card de preço completo.
                                if (isset($game['discount_percent']) && isset($game['final_price'])): ?>
                                    <div class="card-pricing">
                                        <span class="discount-tag">-<?php echo htmlspecialchars($game['discount_percent']); ?>%</span>
                                        <span class="final-price">R$ <?php echo number_format($game['final_price'], 2, ',', '.'); ?></span>
                                    </div>
                                <?php else: // Se não tiver desconto, mostra o preço simples. ?>
                                    <div class="card-pricing-simple">
                                        <span class="final-price">R$ <?php echo number_format($game['price'], 2, ',', '.'); ?></span>
                                    </div>
                                <?php endif; ?>

                            </div>
                        </div>
                    </a>

                <?php endforeach; ?>
            </div>
        </section>

    <?php endforeach; ?>

</div>

<form action="index.php?route=cart&action=add" method="post" class="mt-auto">
    <input type="hidden" name="game_id" value="<?php echo $game['id']; ?>">
    <button type="submit" class="btn btn-primary w-100">Adicionar ao Carrinho</button>
</form>

<?php require __DIR__ . '/../layout/footer.php'; ?>