<?php require __DIR__ . '/../layout/header.php'; ?>

<div class="container">
    <h1 class="mb-4">Seu Carrinho de Compras</h1>
    <a href="index.php?route=cart&action=remove&game_id=<?php echo $item['id']; ?>" class="btn btn-sm btn-danger">
    <i class="fas fa-trash-alt"></i>
</a>

    <?php if (empty($cartItems)): ?>
        <div class="alert alert-info text-center" style="background-color: var(--cor-card); border-color: var(--cor-botao); color: var(--cor-texto-principal);">
            <p class="mb-0">Seu carrinho está vazio.</p>
            <a href="index.php" class="btn btn-primary mt-3">Ver Jogos</a>
        </div>
    <?php else: ?>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th colspan="2">Produto</th>
                    <th class="text-center">Preço</th>
                    <th class="text-center">Quantidade</th>
                    <th class="text-end">Subtotal</th>
                    <th></th> </tr>
            </thead>
            <tbody>
                <?php foreach($cartItems as $item): 
                    // Lógica inteligente para a imagem
                    $imagePath = htmlspecialchars($item['image'] ?? '');
                    if (filter_var($imagePath, FILTER_VALIDATE_URL)) {
                        $imageUrl = $imagePath;
                    } else if (!empty($imagePath)) {
                        $imageUrl = 'uploads/' . $imagePath;
                    } else {
                        $imageUrl = 'https://via.placeholder.com/100x75/1f2b57/a3b6e6?text=Sem+Imagem';
                    }
                ?>
                    <tr>
                        <td style="width: 100px;"><img src="<?php echo $imageUrl; ?>" alt="<?php echo htmlspecialchars($item['title']); ?>" class="img-fluid rounded"></td>
                        <td class="align-middle"><h5 class="mb-0"><?php echo htmlspecialchars($item['title']); ?></h5></td>
                        <td class="align-middle text-center">R$ <?php echo number_format($item['price'], 2, ',', '.'); ?></td>
                        <td class="align-middle text-center"><?php echo $item['quantity']; ?></td>
                        <td class="align-middle text-end">R$ <?php echo number_format($item['price'] * $item['quantity'], 2, ',', '.'); ?></td>
                        
                        <td class="align-middle text-center">
                            <a href="index.php?route=cart&action=remove&game_id=<?php echo $item['id']; ?>" class="btn btn-sm btn-danger" title="Remover item">
                                <i class="fas fa-trash-alt"></i>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div class="text-end mt-4">
            <h3>Total: <span style="color: var(--cor-desconto);">R$ <?php echo number_format($total, 2, ',', '.'); ?></span></h3>
            <a href="#" class="btn btn-success btn-lg">Finalizar Compra</a>
        </div>
    <?php endif; ?>
</div>

<?php require __DIR__ . '/../layout/footer.php'; ?>