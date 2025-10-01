<?php require __DIR__ . '/../layout/header.php'; ?>

 <h2><?php echo htmlentities($game['title']); ?></h2>

    <?php
    // --- LÓGICA DE IMAGEM CORRIGIDA ---
    // 1. Pega o valor da coluna 'image'
    $imagePath = htmlspecialchars($game['image'] ?? '');

    // 2. Decide qual é o link final da imagem
    if (filter_var($imagePath, FILTER_VALIDATE_URL)) {
        // Se for um link completo (http://...), usa ele diretamente
        $imageUrl = $imagePath;
    } else if (!empty($imagePath)) {
        // Se for só um nome de arquivo, adiciona o caminho 'uploads/'
        // O caminho deve ser relativo à raiz do site (onde está o index.php principal)
        $imageUrl = 'uploads/' . $imagePath;
    } else {
        // Se estiver vazio, não mostra a tag de imagem ou usa uma padrão
        $imageUrl = null; 
    }
    // --- FIM DA LÓGICA ---
    ?>

    <?php if ($imageUrl): // Só mostra a imagem se houver um caminho válido ?>
        <img src="<?php echo $imageUrl; ?>" alt="<?php echo htmlentities($game['title']); ?>" style="width:200px; height:auto; margin-bottom:15px;">
    <?php endif; ?>

<p><strong>Categoria:</strong> <?php echo htmlentities($game['category_name'] ?? '—'); ?></p>
<p><strong>Preço:</strong> R$ <?php echo number_format($game['price'],2,',','.'); ?></p>
<p><strong>Descrição:</strong><br><?php echo nl2br(htmlentities($game['description'])); ?></p>
<p><strong>Steam Key:</strong> <?php echo htmlentities($game['steam_key']); ?></p>

<a class="btn btn-secondary mt-3" href="index.php?route=games&action=list">Voltar</a>

<?php require __DIR__ . '/../layout/footer.php'; ?>
