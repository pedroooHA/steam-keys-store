<?php require __DIR__ . '/../layout/header.php'; ?>

<div class="container">

    <div class="form-container">

        <h2>Cadastrar</h2>
        <form method="post" action="index.php?route=register">
            <div class="mb-3">
                <label for="name" class="form-label">Nome</label>
                <input id="name" class="form-control" type="text" name="name" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input id="email" class="form-control" type="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Senha</label>
                <input id="password" class="form-control" type="password" name="password" required>
            </div>
            <button class="btn btn-primary">Cadastrar</button>
        </form>

    </div>
</div>

<?php require __DIR__ . '/../layout/footer.php'; ?>