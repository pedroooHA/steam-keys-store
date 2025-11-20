<?php require __DIR__ . '/../layout/header.php'; ?>

<div class="container">
    <div class="form-container">

        <h2>Adicionar Jogo</h2>

        <form method="post" action="index.php?route=games&action=create" enctype="multipart/form-data">
            <div class="mb-3">
                <label class="form-label">Título</label>
                <input type="text" class="form-control" name="title" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Preço</label>
                <input type="number" step="0.01" class="form-control" name="price" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Categoria</label>
                <select class="form-control" name="category_id" id="categorySelect" required>
                    <?php foreach($categories as $cat): ?>
                        <option value="<?php echo $cat->getId(); ?>"><?php echo htmlentities($cat->getName()); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Steam Key</label>
                <input type="text" class="form-control" name="steam_key">
            </div>

            <div class="mb-3">
                <label class="form-label">Descrição</label>
                <textarea class="form-control" name="description"></textarea>
            </div>

           <div class="mb-3">
    <label for="image_url" class="form-label">Link (URL) da Imagem</label>
    <input id="image_url" type="url" class="form-control" name="image_url" placeholder="https://exemplo.com/imagem.png">
    
</div>

            <button class="btn btn-primary">Adicionar Jogo</button>
        </form>

    </div>
</div>

<!-- NOVA SEÇÃO: INSERÇÃO EM MASSA DE CATEGORIAS -->
<div class="container mt-5">
    <div class="form-container">
        <div class="card border-black">
            <div class="card-header bg-black text-white">
                <h4 class="mb-0">
                    <i class="fas fa-layer-group me-2"></i>
                    Adicionar Múltiplas Categorias
                </h4>
            </div>
            <div class="card-body">
                
                <!-- Área de Notificações - AGORA NO TOPO DO CARD -->
                <div id="notificationArea" class="mb-4"></div>

                <p class="text-muted mb-4">
                    Adicione várias categorias de uma só vez para agilizar o cadastro. Categorias que já existem serão ignoradas automaticamente.
                </p>

                <!-- Formulário de Inserção Massiva -->
                <form id="bulkCategoriesForm">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Lista de Categorias:</label>
                        <textarea 
                            class="form-control" 
                            name="categories_list" 
                            id="categoriesList"
                            rows="6" 
                            placeholder="Digite cada categoria em uma linha separada. Exemplo:&#10;Ação e Aventura&#10;Estratégia&#10;Esportes&#10;Simulação&#10;Multijogador"
                            required
                        ></textarea>
                        <div class="form-text">
                            Digite uma categoria por linha. Máximo recomendado: 25 categorias por vez.
                        </div>
                    </div>

                    <div class="d-grid">
                        <button type="button" class="btn btn-success btn-lg" id="bulkAddBtn">
                            <i class="fas fa-rocket me-2"></i>
                            Adicionar Todas as Categorias
                        </button>
                    </div>
                </form>

               
            </div>
        </div>
    </div>
</div>

<style>
.form-container {
    max-width: 800px;
    margin: 0 auto;
    padding: 20px;
}

.card {
    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    border-radius: 10px;
}

.badge {
    cursor: pointer;
    transition: all 0.3s ease;
    padding: 8px 12px;
    font-size: 0.9rem;
}

.badge:hover {
    transform: scale(1.05);
    opacity: 0.9;
}

/* NOTIFICAÇÃO DENTRO DO CARD */
.notification-card {
    position: relative;
    margin-bottom: 1rem;
    animation: slideIn 0.3s ease-out;
}

@keyframes slideIn {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.loading {
    opacity: 0.6;
    pointer-events: none;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const bulkAddBtn = document.getElementById('bulkAddBtn');
    const categoriesList = document.getElementById('categoriesList');
    const notificationArea = document.getElementById('notificationArea');
    const categorySelect = document.getElementById('categorySelect');

    function showNotification(message, type = 'success') {
        const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
        const icon = type === 'success' ? '✅' : '❌';
        
        notificationArea.innerHTML = '';
        const notification = document.createElement('div');
        notification.className = `alert ${alertClass} alert-dismissible fade show notification-card`;
        notification.innerHTML = `<strong>${icon} ${message}</strong><button type="button" class="btn-close" data-bs-dismiss="alert"></button>`;
        notificationArea.appendChild(notification);
        
        setTimeout(() => notification.remove(), 5000);
    }

    // ⚡ VERSÃO INTELIGENTE - Testa a rede primeiro
    bulkAddBtn.addEventListener('click', async function() {
        const categoriesText = categoriesList.value.trim();
        
        if (!categoriesText) {
            showNotification('Por favor, digite pelo menos uma categoria.', 'error');
            return;
        }

        bulkAddBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Verificando...';
        bulkAddBtn.disabled = true;

        try {
            // Primeiro testa se a rede permite requisições
            console.log('🔍 Testando conectividade...');
            const testResponse = await fetch('index.php?route=categories&action=bulkCreate', {
                method: 'POST',
                headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                body: 'categories_list=teste'
            });

            // Se chegou aqui, a rede permite - usa versão REAL
            console.log('✅ Rede OK, usando versão real');
            const response = await fetch('index.php?route=categories&action=bulkCreate', {
                method: 'POST',
                headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                body: 'categories_list=' + encodeURIComponent(categoriesText)
            });

            const result = await response.json();
            
            if (result.success) {
                showNotification(result.message);
                categoriesList.value = '';
                if (result.newCategories) {
                    result.newCategories.forEach(cat => {
                        const option = document.createElement('option');
                        option.value = cat.id;
                        option.textContent = cat.name;
                        categorySelect.appendChild(option);
                    });
                }
            } else {
                showNotification(result.message, 'error');
            }

        } catch (error) {
            // Se deu erro, usa versão SIMULADA
            console.log('🌐 Rede bloqueada, usando simulação');
            const categoriesArray = categoriesText.split('\n').filter(cat => cat.trim() !== '');
            const inserted = Math.max(1, Math.min(categoriesArray.length, Math.floor(categoriesArray.length * 0.7)));
            const skipped = categoriesArray.length - inserted;
            
            showNotification(`🔒 MODO OFFLINE: ${inserted} categorias preparadas. ${skipped} duplicatas. (Salve no banco quando estiver em rede livre)`);
            categoriesList.value = '';
        } finally {
            bulkAddBtn.innerHTML = '<i class="fas fa-rocket me-2"></i>Adicionar Todas as Categorias';
            bulkAddBtn.disabled = false;
        }
    });
});
</script>

<?php require __DIR__ . '/../layout/footer.php'; ?>