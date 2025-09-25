<?php require __DIR__ . '/../layout/header.php'; ?>

<div class="d-flex justify-content-between align-items-center">
  <h2>Jogos</h2>
  
  <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
    <a class="btn btn-primary" href="index.php?route=games&action=create">Adicionar jogo</a>
  <?php endif; ?>
  
</div>

<table class="table table-striped mt-3">
  <thead>
    <tr>
      <th>Título</th>
      <th>Categoria</th>
      <th>Preço</th>
      <th>Ações</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach($games as $g): ?>
      <tr>
        <td><?php echo htmlentities($g['title']); ?></td>
        <td><?php echo htmlentities($g['category_name'] ?? '—'); ?></td>
        <td>R$ <?php echo number_format($g['price'],2,',','.'); ?></td>
        <td>
          <a class="btn btn-sm btn-outline-primary" href="index.php?route=games&action=view&id=<?php echo $g['id']; ?>">Ver</a>
        </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<?php require __DIR__ . '/../layout/footer.php'; ?>
