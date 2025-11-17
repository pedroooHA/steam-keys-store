<?php include '../../header.php'; ?>

<div class="admin-container">
    <div class="admin-header">
        <h1><i class="fas fa-cog"></i> Painel de Controle</h1>
        <p class="admin-subtitle">Bem-vindo, <?php echo htmlspecialchars($user->name); ?>!</p>
    </div>

    <div class="admin-stats">
        <div class="row g-4">
            <!-- Estatísticas dinâmicas (substitua pelos dados reais do seu banco) -->
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-gamepad"></i>
                    </div>
                    <div class="stat-info">
                        <h3><?php echo Game::countAll(); ?></h3>
                        <p>Total de Jogos</p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="stat-info">
                        <h3><?php echo User::countAll(); ?></h3>
                        <p>Usuários Cadastrados</p>
                    </div>
                </div>
            </div>
            
            <!-- Adicione mais estatísticas conforme necessário -->
        </div>
    </div>

    <div class="admin-actions">
        <div class="row g-4">
            <div class="col-md-4">
                <div class="action-card">
                    <div class="action-icon">
                        <i class="fas fa-plus-circle"></i>
                    </div>
                    <h4>Adicionar Jogo</h4>
                    <p>Cadastre novos jogos na loja</p>
                    <a href="index.php?route=admin&action=add-game" class="action-btn">Acessar</a>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="action-card">
                    <div class="action-icon">
                        <i class="fas fa-user-cog"></i>
                    </div>
                    <h4>Gerenciar Usuários</h4>
                    <p>Visualize e gerencie usuários</p>
                    <a href="index.php?route=admin&action=users" class="action-btn">Acessar</a>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="action-card">
                    <div class="action-icon">
                        <i class="fas fa-chart-bar"></i>
                    </div>
                    <h4>Relatórios</h4>
                    <p>Relatórios de vendas e analytics</p>
                    <a href="index.php?route=admin&action=reports" class="action-btn">Acessar</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Adicione o CSS do admin aqui (o mesmo que te enviei anteriormente) -->
<style>
/* ================================
   ESTILO DO PAINEL DE CONTROLE
   ================================ */

.admin-container {
    max-width: 1200px;
    margin: 40px auto;
    padding: 0 20px;
}

/* HEADER DO PAINEL */
.admin-header {
    text-align: center;
    padding: 40px 30px;
    background: #121212;
    border-radius: 18px;
    color: #fff;
    box-shadow: 0 6px 20px rgba(0,0,0,0.15);
}

.admin-header h1 {
    font-size: 2.4rem;
    font-weight: 700;
    margin-bottom: 10px;
}

.admin-header h1 i {
    margin-right: 10px;
    color: #ffc83d;
}

.admin-subtitle {
    font-size: 1.1rem;
    opacity: 0.85;
}

/* CARDS DE ESTATÍSTICAS */
.stat-card {
    background: #ffffff;
    border-radius: 16px;
    padding: 25px;
    display: flex;
    align-items: center;
    gap: 20px;
    box-shadow: 0 4px 18px rgba(0,0,0,0.08);
    transition: 0.2s ease-in-out;
}

.stat-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 6px 22px rgba(0,0,0,0.12);
}

.stat-icon {
    width: 60px;
    height: 60px;
    border-radius: 14px;
    background: #000;
    display: flex;
    align-items: center;
    justify-content: center;
}

.stat-icon i {
    font-size: 1.8rem;
    color: #fff;
}

.stat-info h3 {
    font-size: 1.9rem;
    font-weight: 700;
    margin: 0;
    color: #000;
}

.stat-info p {
    margin: 0;
    font-size: 1rem;
    color: #444;
}

/* CARDS DE AÇÕES */
.action-card {
    background: #ffffff;
    border-radius: 18px;
    padding: 30px 25px;
    text-align: center;
    box-shadow: 0 4px 18px rgba(0,0,0,0.08);
    transition: 0.2s ease;
}

.action-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 6px 22px rgba(0,0,0,0.12);
}

.action-icon {
    width: 70px;
    height: 70px;
    margin: 0 auto 15px;
    border-radius: 50%;
    background: #000;
    display: flex;
    justify-content: center;
    align-items: center;
}

.action-icon i {
    font-size: 2rem;
    color: #fff;
}

.action-card h4 {
    font-size: 1.3rem;
    font-weight: 700;
    margin-top: 10px;
    color: #000;
}

.action-card p {
    font-size: 0.95rem;
    color: #555;
    margin-bottom: 20px;
}

.action-btn {
    display: inline-block;
    background: #000;
    color: #fff;
    padding: 10px 20px;
    border-radius: 12px;
    font-weight: 600;
    text-decoration: none;
    transition: 0.2s ease;
}

.action-btn:hover {
    background: #222;
}

/* Ajuste no espaçamento inferior */
.admin-actions {
    margin-top: 40px;
    margin-bottom: 60px;
}

</style>

<?php include '../../footer.php'; ?>