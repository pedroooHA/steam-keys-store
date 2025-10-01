<?php require __DIR__ . '/../layout/header.php'; ?>

<div class="container">
    <div class="form-container">
        <h2>Login</h2>
        <form method="post" action="index.php?route=login">
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input id="email" class="form-control" type="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Senha</label>
                <input id="password" class="form-control" type="password" name="password" required>
            </div>
            <button class="btn btn-primary">Entrar</button>
        </form>
    </div>
</div>

<?php require __DIR__ . '/../layout/footer.php'; ?>