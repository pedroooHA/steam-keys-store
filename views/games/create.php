<?php require __DIR__ . '/../layout/header.php'; ?>

<h2>Adicionar Jogo</h2>

<form method="post" action="index.php?route=games&action=create" enctype="multipart/form-data">
    <div class="mb-3">
        <label>Título</label>
        <input type="text" class="form-control" name="title" required>
    </div>

    <div class="mb-3">
        <label>Preço</label>
        <input type="number" step="0.01" class="form-control" name="price" required>
    </div>

    <div class="mb-3">
        <label>Categoria</label>
        <select class="form-control" name="category_id" required>
            <?php foreach($categories as $cat): ?>
                <option value="<?php echo $cat->getId(); ?>"><?php echo htmlentities($cat->getName()); ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="mb-3">
        <label>Steam Key</label>
        <input type="text" class="form-control" name="steam_key">
    </div>

    <div class="mb-3">
        <label>Descrição</label>
        <textarea class="form-control" name="description"></textarea>
    </div>

    <div class="mb-3">
        <label>Imagem</label>
        <input type="file" class="form-control" name="image" accept="image/*">
    </div>

    <button class="btn btn-primary">Adicionar Jogo</button>
</form>

<?php require __DIR__ . '/../layout/footer.php'; ?>
