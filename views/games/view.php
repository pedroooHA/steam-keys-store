<?php require __DIR__ . '/../layout/header.php'; ?>

<h2><?php echo htmlentities($game['title']); ?></h2>

<?php if(!empty($game['image'])): ?>
    <img src="uploads/<?php echo $game['image']; ?>" alt="<?php echo htmlentities($game['title']); ?>" style="width:200px; height:auto; margin-bottom:15px;">
<?php endif; ?>

<p><strong>Categoria:</strong> <?php echo htmlentities($game['category_name'] ?? '—'); ?></p>
<p><strong>Preço:</strong> R$ <?php echo number_format($game['price'],2,',','.'); ?></p>
<p><strong>Descrição:</strong><br><?php echo nl2br(htmlentities($game['description'])); ?></p>
<p><strong>Steam Key:</strong> <?php echo htmlentities($game['steam_key']); ?></p>

<a class="btn btn-secondary mt-3" href="index.php?route=games&action=list">Voltar</a>

<?php require __DIR__ . '/../layout/footer.php'; ?>
