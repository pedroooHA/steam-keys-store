<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel Administrativo - Nexus Keys</title>
    <link rel="stylesheet" href="/assets/css/style.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .admin-container {
            max-width: 1200px;
            margin: 40px auto;
            padding: 0 20px;
        }

        /* HEADER DO PAINEL */
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

        .admin-header h1 i {
            margin-right: 10px;
        }

        .admin-subtitle {
            font-size: 1.1rem;
            opacity: 0.85;
            color: #b0b0b0;
        }

        /* CARDS DE ESTATÍSTICAS */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 25px;
            margin-bottom: 40px;
        }

        .stat-card {
            background: #000000ff;
            border-radius: 16px;
            padding: 25px;
            display: flex;
            align-items: center;
            gap: 20px;
            box-shadow: 0 4px 18px rgba(0,0,0,0.08);
            transition: 0.2s ease-in-out;
            border: 1px solid #333;
        }

        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 6px 22px rgba(255,200,61,0.15);
            border-color: #ffffffff;
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 14px;
            background: #ffffffff;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .stat-icon i {
            font-size: 1.8rem;
            color: #000000ff;
        }

        .stat-info h3 {
            font-size: 1.9rem;
            font-weight: 700;
            margin: 0;
            color: #ffffffff;
        }

        .stat-info p {
            margin: 0;
            font-size: 1rem;
            color: #b0b0b0;
        }

        /* CARDS DE AÇÕES */
        .admin-actions {
            margin-top: 40px;
        }

        .admin-actions h2 {
            color: #ffffffff;
            margin-bottom: 2rem;
            font-size: 1.8rem;
        }

        .row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 25px;
        }

        .action-card {
            background: #000000ff;
            border-radius: 18px;
            padding: 30px 25px;
            text-align: center;
            box-shadow: 0 4px 18px rgba(0,0,0,0.08);
            transition: 0.2s ease;
            border: 1px solid #333;
            height: 100%;
        }

        .action-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 6px 22px rgba(255,200,61,0.15);
            border-color: #ffffffff;
        }

        .action-icon {
            width: 70px;
            height: 70px;
            margin: 0 auto 15px;
            border-radius: 50%;
            background: #ffffffff;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .action-icon i {
            font-size: 2rem;
            color: #121212;
        }

        .action-card h4 {
            font-size: 1.3rem;
            font-weight: 700;
            margin-top: 10px;
            color: #ffffffff;
        }

        .action-card p {
            font-size: 0.95rem;
            color: #b0b0b0;
            margin-bottom: 20px;
        }

        .action-btn {
            display: inline-block;
            background: #ffffffff;
            color: #121212;
            padding: 10px 20px;
            border-radius: 12px;
            font-weight: 600;
            text-decoration: none;
            transition: 0.2s ease;
        }

        .action-btn:hover {
            background: #80ff00ff;
            color: #121212;
        }

        /* Mensagens de alerta */
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

    <?php $user = getCurrentUser(); ?>
    
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
                <h1><i class="fas fa-cogs"></i> Painel Administrativo</h1>
                <p class="admin-subtitle">Bem-vindo, <?php echo htmlspecialchars($user->getName()); ?>!</p>
            </div>

            <!-- Estatísticas -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-gamepad"></i>
                    </div>
                    <div class="stat-info">
                        <h3><?php echo $total_games; ?></h3>
                        <p>Jogos Cadastrados</p>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="stat-info">
                        <h3><?php echo $total_users; ?></h3>
                        <p>Usuários Registrados</p>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-tags"></i>
                    </div>
                    <div class="stat-info">
                        <h3><?php echo $total_categories; ?></h3>
                        <p>Categorias</p>
                    </div>
                </div>
            </div>

            <!-- Ações Rápidas -->
            <div class="admin-actions">
                <h2>Ações Rápidas</h2>
                <div class="row">
                    <div class="action-card">
                        <div class="action-icon">
                            <i class="fas fa-plus"></i>
                        </div>
                        <h4>Cadastrar Jogo</h4>
                        <p>Adicione um novo jogo ao catálogo</p>
                        <a href="index.php?route=games&action=create" class="action-btn">Acessar</a>
                    </div>
                    
                    <div class="action-card">
                        <div class="action-icon">
                            <i class="fas fa-list"></i>
                        </div>
                        <h4>Gerenciar Jogos</h4>
                        <p>Edite ou remova jogos existentes</p>
                        <a href="/?route=games&action=list" class="action-btn">Acessar</a>
                    </div>
                    
                    <div class="action-card">
                        <div class="action-icon">
                            <i class="fas fa-users-cog"></i>
                        </div>
                        <h4>Gerenciar Usuários</h4>
                        <p>Visualize e gerencie usuários</p>
                        <a href="/?route=admin&action=users" class="action-btn">Acessar</a>
                    </div>

                    <div class="action-card">
                        <div class="action-icon">
                            <i class="fas fa-chart-bar"></i>
                        </div>
                        <h4>Relatórios</h4>
                        <p>Visualize relatórios de vendas</p>
                        <a href="/?route=admin&action=reports" class="action-btn">Acessar</a>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <?php require __DIR__ . '/../layout/footer.php'; ?>
</body>
</html>