<?php require __DIR__ . '/../layout/header.php'; ?>

<div class="d-flex justify-content-between align-items-center">
  <h2>Categorias</h2>

  <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
    <form class="d-flex" method="post" action="index.php?route=categories&action=create">
      <input class="form-control me-2" name="name" placeholder="Nova categoria" required>
      <button class="btn btn-primary">Adicionar</button>
    </form>
  <?php endif; ?>

</div>

<table class="table mt-3">
  <thead>
    <tr><th>ID</th><th>Nome</th></tr>
  </thead>
  <tbody>
    <?php foreach($categories as $c): ?>
      <tr>
        <td><?php echo $c->getId(); ?></td>
        <td>
    <a href="index.php?route=games&action=list&category_id=<?php echo $c->getId(); ?>" style="text-decoration: none; color: inherit;">
        <?php echo htmlentities($c->getName()); ?>
    </a>
</td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<?php require __DIR__ . '/../layout/footer.php'; ?>
