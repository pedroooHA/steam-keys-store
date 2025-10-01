<?php require __DIR__ . '/layout/header.php'; ?>

<div class="container">
    <h1>Nossos Jogos</h1>

    <div class="row">
        <?php foreach ($games as $game): // Padronizei a variável para '$game' por clareza ?>
            <?php
                // Lógica de Imagem Inteligente que já fizemos
                $imagePath = htmlspecialchars($game['image'] ?? '');
                if (filter_var($imagePath, FILTER_VALIDATE_URL)) {
                    $imageUrl = $imagePath;
                } else if (!empty($imagePath)) {
                    $imageUrl = 'uploads/' . $imagePath;
                } else {
                    $imageUrl = 'https://via.placeholder.com/400x300/1f2b57/a3b6e6?text=Sem+Imagem';
                }
            ?>
            <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
                <div class="game-card h-100 d-flex flex-column">
                    <a href="index.php?route=games&action=view&id=<?php echo $game['id']; ?>" class="card-link-header">
                        <header class="card-header">
                            <img src="<?php echo $imageUrl; ?>" alt="<?php echo htmlspecialchars($game['title']); ?>" class="card-img">
                            <div class="steam-tag"><i class="fa-brands fa-steam"></i> Steam</div>
                        </header>
                    </a>
                    <div class="card-body d-flex flex-column">
                        <h3 class="card-title"><?php echo htmlspecialchars($game['title']); ?></h3>
                        <div class="card-pricing-simple">
                            <span class="final-price">R$ <?php echo number_format($game['price'], 2, ',', '.'); ?></span>
                        </div>
                        
                        <form action="index.php?route=cart&action=add" method="post" class="mt-auto">
                            <input type="hidden" name="game_id" value="<?php echo $game['id']; ?>">
                            <button type="submit" class="btn btn-primary w-100">Adicionar ao Carrinho</button>
                        </form>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php require __DIR__ . '/layout/footer.php'; ?>