<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Usuários - Nexus Keys</title>
    <link rel="stylesheet" href="/assets/css/style.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .admin-container {
            max-width: 1200px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .admin-header {
            text-align: center;
            padding: 40px 30px;
            background: #000000ff;
            border-radius: 18px;
            color: #fff;
            box-shadow: 0 6px 20px rgba(0,0,0,0.15);
            border: 1px solid #333;
            margin-bottom: 40px;
        }

        .admin-header h1 {
            font-size: 2.4rem;
            font-weight: 700;
            margin-bottom: 10px;
            color: #ffffffff;
        }

        .users-table {
            background: #000000ff;
            border-radius: 18px;
            padding: 30px;
            box-shadow: 0 4px 18px rgba(0,0,0,0.08);
            border: 1px solid #333;
            overflow-x: auto;
        }

        .users-table h2 {
            color: #ffffffff;
            margin-bottom: 25px;
            font-size: 1.8rem;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            color: #ffffffff;
        }

        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #333;
            color: white;
        }

        a.btn.btn-edit, a.btn.btn-delete {
            text-decoration: none;
            padding: 8px 16px;
            border-radius: 8px;
            font-weight: 600;
            margin: 0 5px;
            transition: 0.2s ease;
            display: inline-block;
            color: white;
        }

        th {
            background: #1a1a1a;
            font-weight: 600;
            color: #ffffffff;
        }

        tr:hover {
            background: #1a1a1a;
        }

        .btn {
            padding: 8px 16px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            margin: 0 5px;
            transition: 0.2s ease;
            display: inline-block;
        }

        .btn-edit {
            background: #ffffffff;
            color: #121212;
        }

        .btn-edit:hover {
            background: #80ff00ff;
        }

        .btn-delete {
            background: #dc3545;
            color: white;
        }

        .btn-delete:hover {
            background: #c82333;
        }

        .role-admin {
            color: #80ff00ff;
            font-weight: 600;
        }

        .role-user {
            color: #b0b0b0;
        }

        .alert {
            padding: 15px 20px;
            border-radius: 12px;
            margin-bottom: 20px;
            border: 1px solid;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
            border-color: #c3e6cb;
        }

        .alert-error {
            background: #f8d7da;
            color: #721c24;
            border-color: #f5c6cb;
        }
    </style>
</head>
<body>
    <?php require __DIR__ . '/../layout/header.php'; ?>
    
    <main class="main-content">
        <div class="admin-container">
            <!-- Mensagens -->
            <?php if(isset($_SESSION['success'])): ?>
                <div class="alert alert-success">
                    <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
                </div>
            <?php endif; ?>

            <?php if(isset($_SESSION['error'])): ?>
                <div class="alert alert-error">
                    <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
                </div>
            <?php endif; ?>

            <div class="admin-header">
                <h1><i class="fas fa-users-cog"></i> Gerenciar Usuários</h1>
                <p class="admin-subtitle">Gerencie os usuários do sistema</p>
            </div>

            <div class="users-table">
                <h2>Lista de Usuários</h2>
                
                <?php if (!empty($users)): ?>
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nome</th>
                                <th>Email</th>
                                <th>Função</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($users as $user): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($user->getId()); ?></td>
                                    <td><?php echo htmlspecialchars($user->getName()); ?></td>
                                    <td><?php echo htmlspecialchars($user->getEmail()); ?></td>
                                    <td>
                                        <span class="<?php echo $user->getRole() === 'admin' ? 'role-admin' : 'role-user'; ?>">
                                            <?php echo htmlspecialchars($user->getRole()); ?>
                                        </span>
                                    </td>
                                    <td>
                                        
                                        <?php if ($user->getId() != getCurrentUser()->getId()): ?>
                                            <a href="?route=admin&action=delete_user&id=<?php echo $user->getId(); ?>" 
                                               class="btn btn-delete" 
                                               onclick="return confirm('Tem certeza que deseja excluir este usuário?')">
                                                <i class="fas fa-trash"></i> Excluir
                                            </a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p style="color: #b0b0b0; text-align: center;">Nenhum usuário cadastrado.</p>
                <?php endif; ?>
            </div>
        </div>
    </main>

    <?php require __DIR__ . '/../layout/footer.php'; ?>
</body>
</html>