<?php require 'views/layout/header.php'; ?>
<h1>Todos os Jogos</h1>
<div class="row">
<?php foreach($games as $g): ?>
  <div class="col-md-4 mb-3">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title"><?php echo htmlentities($g['title']); ?></h5>
        <p class="card-text"><?php echo htmlentities($g['category_name'] ?? '—'); ?></p>
        <p class="card-text">R$ <?php echo number_format($g['price'],2,',','.'); ?></p>
        <a href="index.php?route=games&action=view&id=<?php echo $g['id']; ?>" class="btn btn-primary">Ver</a>
      </div>
    </div>
  </div>
<?php endforeach; ?>
</div>
<?php require 'views/layout/footer.php'; ?>