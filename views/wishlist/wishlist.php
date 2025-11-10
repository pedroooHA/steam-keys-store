<?php
session_start();
require_once 'models/WishlistModel.php';
require_once 'models/User.php';
require_once 'models/Database.php';

// Confere login
if (empty($_SESSION['user_id'])) {
    header("Location: index.php?route=login");
    exit;
}

$wishlistModel = new WishlistModel();
$wishlist = $wishlistModel->listarPorUsuario($_SESSION['user_id']);
?>

<?php include 'header.php'; ?>

<main class="container my-5">
    <h2 class="mb-4">Minha Li de Desejos</h2>

    <?php if (empty($wishlist)): ?>
        <p>Você ainda não adicionou nenhum jogo à sua lista de desejos.</p>
    <?php else: ?>
        <div class="row g-4">
            <?php foreach ($wishlist as $jogo): ?>
                <div class="col-md-3 col-sm-6">
                    <div class="card h-100 shadow-sm">
                        <img src="<?php echo htmlspecialchars($jogo['imagem']); ?>" 
                             class="card-img-top" 
                             alt="<?php echo htmlspecialchars($jogo['titulo']); ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($jogo['titulo']); ?></h5>
                            <p class="card-text text-muted">R$ <?php echo number_format($jogo['preco'], 2, ',', '.'); ?></p>
                            <a href="index.php?route=game&id=<?php echo $jogo['id']; ?>" class="btn btn-dark btn-sm w-100 mb-2">
                                Ver jogo
                            </a>
                            <a href="index.php?route=wishlist_remove&id=<?php echo $jogo['id']; ?>" class="btn btn-outline-danger btn-sm w-100">
                                Remover
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</main>

<?php include 'footer.php'; ?>
