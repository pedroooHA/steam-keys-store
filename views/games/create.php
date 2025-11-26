<?php require __DIR__ . '/../layout/header.php'; ?>

<div class="container">
    <!-- CARD DE ADICIONAR JOGO -->
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card border-black mb-5">
                <div class="card-header bg-black text-white">
                    <h4 class="mb-0">
                        <i class="fas fa-gamepad me-2"></i>
                        Adicionar Novo Jogo
                    </h4>
                </div>
                <div class="card-body p-4">
                    
                    <!-- Notificações -->
                    <div id="gameNotificationArea" class="mb-4"></div>

                    <form method="post" action="index.php?route=games&action=create" enctype="multipart/form-data" id="addGameForm">
                        <div class="row">
                            <!-- Coluna Esquerda - Informações Básicas -->
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <label class="form-label fw-bold">Título do Jogo *</label>
                                    <input type="text" class="form-control form-control-lg" name="title" required 
                                           placeholder="Ex: The Witcher 3: Wild Hunt">
                                </div>

                                <div class="mb-4">
                                    <label class="form-label fw-bold">Preço *</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light">R$</span>
                                        <input type="number" step="0.01" class="form-control form-control-lg" 
                                               name="price" required placeholder="79.90" min="0.01">
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label fw-bold">Estoque</label>
                                    <input type="number" class="form-control form-control-lg" name="estoque" 
                                           placeholder="Quantidade em estoque" min="0" value="0">
                                </div>

                                <div class="mb-4">
                                    <label class="form-label fw-bold">Categoria *</label>
                                    <select class="form-select form-select-lg" name="category_id" id="categorySelect" required>
                                        <option value="">Selecione uma categoria</option>
                                        <?php if (!empty($categories)): ?>
                                            <?php foreach($categories as $cat): ?>
                                                <option value="<?php echo $cat->getId(); ?>">
                                                    <?php echo htmlspecialchars($cat->getName()); ?>
                                                </option>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <option value="">Nenhuma categoria disponível</option>
                                        <?php endif; ?>
                                    </select>
                                    
                                    <div class="mt-2">
                                        <button type="button" class="btn btn-sm btn-outline-primary" id="reloadCategoriesBtn">
                                            <i class="fas fa-sync-alt me-1"></i>Recarregar Categorias
                                        </button>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label fw-bold">Steam Key</label>
                                    <input type="text" class="form-control" name="steam_key" 
                                           placeholder="Ex: A1B2C-D3E4F-G5H6I-J7K8L">
                                    <div class="form-text">
                                        Chave de ativação na Steam (opcional)
                                    </div>
                                </div>
                            </div>

                            <!-- Coluna Direita - Descrição e Imagem -->
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <label class="form-label fw-bold">Descrição</label>
                                    <textarea class="form-control" name="description" rows="6" 
                                              placeholder="Descreva o jogo, seus recursos principais, requisitos do sistema, etc..."></textarea>
                                    <div class="form-text">
                                        Máximo recomendado: 500 caracteres
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label fw-bold">Imagem do Jogo</label>
                                    
                                    <!-- Opção de URL -->
                                    <div class="mb-3">
                                        <label class="form-label">Link da Imagem (URL)</label>
                                        <input type="url" class="form-control" name="image_url" 
                                               placeholder="https://exemplo.com/imagem.jpg">
                                    </div>

                                    <!-- Ou Upload -->
                                    <div class="mb-3">
                                        <label class="form-label">Ou faça upload de uma imagem</label>
                                        <input type="file" class="form-control" name="image_upload" 
                                               accept="image/jpeg, image/png, image/gif, image/webp">
                                        <div class="form-text">
                                            Formatos: JPG, PNG, GIF, WebP. Tamanho máximo: 2MB
                                        </div>
                                    </div>

                                    <!-- Preview da Imagem -->
                                    <div id="imagePreview" class="mt-3 text-center" style="display: none;">
                                        <p class="small text-muted mb-2">Preview:</p>
                                        <img id="previewImage" src="#" alt="Preview" class="img-thumbnail" style="max-height: 150px;">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Botão de Submissão -->
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                            <button type="button" class="btn btn-outline-secondary me-md-2" id="resetFormBtn">
                                <i class="fas fa-undo me-2"></i>Limpar
                            </button>
                            <button type="submit" class="btn btn-primary btn-lg" id="submitGameBtn">
                                <i class="fas fa-plus-circle me-2"></i>Adicionar Jogo
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- CARD DE ADICIONAR CATEGORIAS EM MASSA -->
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card border-black">
                <div class="card-header bg-black text-white">
                    <h4 class="mb-0">
                        <i class="fas fa-layer-group me-2"></i>
                        Adicionar Múltiplas Categorias
                    </h4>
                </div>
                <div class="card-body p-4">
                    
                    <!-- Área de Notificações -->
                    <div id="notificationArea" class="mb-4"></div>

                    <p class="text-muted mb-4">
                        Adicione várias categorias de uma só vez para agilizar o cadastro. Categorias que já existem serão ignoradas automaticamente.
                    </p>

                    <!-- Formulário de Inserção Massiva -->
                    <form id="bulkCategoriesForm">
                        <div class="mb-4">
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
</div>

<style>
.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
}

.card {
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    border-radius: 16px;
    border: 2px solid #000000;
    overflow: hidden;
}

.card-header {
    border-bottom: 2px solid #000000;
    padding: 1.5rem;
}

.card-body {
    padding: 2rem;
}

.form-control, .form-select {
    border-radius: 10px;
    border: 2px solid #f0f0f0;
    padding: 12px 15px;
    transition: all 0.3s ease;
    font-size: 1rem;
}

.form-control:focus, .form-select:focus {
    border-color: #000000;
    box-shadow: 0 0 0 0.2rem rgba(0, 0, 0, 0.1);
}

.form-control-lg {
    padding: 15px;
    font-size: 1.1rem;
}

.form-label {
    font-weight: 600;
    color: #000000;
    margin-bottom: 0.5rem;
    font-size: 1rem;
}

.btn {
    border-radius: 10px;
    padding: 12px 24px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-lg {
    padding: 15px 30px;
    font-size: 1.1rem;
}

.btn-primary {
    background: linear-gradient(135deg, #000000, #333333);
    border: none;
}

.btn-primary:hover {
    background: linear-gradient(135deg, #333333, #555555);
    transform: translateY(-2px);
}

.btn-success {
    background: linear-gradient(135deg, #198754, #157347);
    border: none;
}

.btn-success:hover {
    background: linear-gradient(135deg, #157347, #0f5132);
    transform: translateY(-2px);
}

.notification-card {
    position: relative;
    margin-bottom: 1rem;
    animation: slideIn 0.3s ease-out;
    border-radius: 10px;
    border: none;
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

.img-thumbnail {
    border-radius: 10px;
    border: 2px solid #f0f0f0;
    max-width: 100%;
}

.loading {
    opacity: 0.7;
    pointer-events: none;
}

@media (max-width: 768px) {
    .container {
        padding: 15px;
    }
    
    .card-body {
        padding: 1.5rem;
    }
    
    .btn {
        width: 100%;
        margin-bottom: 10px;
    }
    
    .d-md-flex .btn {
        width: auto;
    }
}

@media (max-width: 576px) {
    .card-body {
        padding: 1rem;
    }
    
    .form-control, .form-select {
        padding: 10px 12px;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('🚀 Página carregada - scripts iniciados');

    // ========== ELEMENTOS DO FORMULÁRIO DE JOGOS ==========
    const addGameForm = document.getElementById('addGameForm');
    const resetFormBtn = document.getElementById('resetFormBtn');
    const submitGameBtn = document.getElementById('submitGameBtn');
    const gameNotificationArea = document.getElementById('gameNotificationArea');
    const imageUrlInput = document.querySelector('input[name="image_url"]');
    const imageUploadInput = document.querySelector('input[name="image_upload"]');
    const imagePreview = document.getElementById('imagePreview');
    const previewImage = document.getElementById('previewImage');
    const reloadCategoriesBtn = document.getElementById('reloadCategoriesBtn');
    const categorySelect = document.getElementById('categorySelect');

    // ========== ELEMENTOS DAS CATEGORIAS EM MASSA ==========
    const bulkAddBtn = document.getElementById('bulkAddBtn');
    const categoriesList = document.getElementById('categoriesList');
    const notificationArea = document.getElementById('notificationArea');

    console.log('✅ Elementos encontrados:', {
        addGameForm: !!addGameForm,
        bulkAddBtn: !!bulkAddBtn,
        categoriesList: !!categoriesList
    });

    // ========== FUNÇÕES DE NOTIFICAÇÃO ==========
    function showGameNotification(message, type = 'success') {
        if (!gameNotificationArea) {
            console.error('Área de notificação de jogos não encontrada');
            alert(message);
            return;
        }

        const alertClass = type === 'success' ? 'alert-success' : 
                          type === 'warning' ? 'alert-warning' : 'alert-danger';
        const icon = type === 'success' ? '✅' : 
                    type === 'warning' ? '⚠️' : '❌';
        
        gameNotificationArea.innerHTML = '';
        const notification = document.createElement('div');
        notification.className = `alert ${alertClass} alert-dismissible fade show notification-card`;
        notification.innerHTML = `
            <strong>${icon} ${message}</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
        gameNotificationArea.appendChild(notification);
        
        setTimeout(() => {
            if (notification.parentNode) {
                notification.remove();
            }
        }, 5000);
    }

    function showNotification(message, type = 'success') {
        if (!notificationArea) {
            console.error('Área de notificação de categorias não encontrada');
            alert(message);
            return;
        }

        const alertClass = type === 'success' ? 'alert-success' : 
                          type === 'warning' ? 'alert-warning' : 'alert-danger';
        const icon = type === 'success' ? '✅' : 
                    type === 'warning' ? '⚠️' : '❌';
        
        notificationArea.innerHTML = '';
        const notification = document.createElement('div');
        notification.className = `alert ${alertClass} alert-dismissible fade show notification-card`;
        notification.innerHTML = `
            <strong>${icon} ${message}</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
        notificationArea.appendChild(notification);
        
        setTimeout(() => {
            if (notification.parentNode) {
                notification.remove();
            }
        }, 5000);
    }

    // ========== FUNCIONALIDADES DO FORMULÁRIO DE JOGOS ==========
    if (addGameForm) {
        addGameForm.addEventListener('submit', function(e) {
            e.preventDefault();
            console.log('📝 Formulário de jogo enviado');
            
            const title = document.querySelector('input[name="title"]').value.trim();
            const price = document.querySelector('input[name="price"]').value;
            const category = document.querySelector('select[name="category_id"]').value;
            
            if (!title || !price || !category) {
                showGameNotification('Por favor, preencha todos os campos obrigatórios (*)', 'error');
                return;
            }
            
            if (parseFloat(price) <= 0) {
                showGameNotification('O preço deve ser maior que zero', 'error');
                return;
            }

            // Mostrar loading
            const originalText = submitGameBtn.innerHTML;
            submitGameBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Adicionando...';
            submitGameBtn.disabled = true;

            // Enviar formulário
            const formData = new FormData(this);
            
            console.log('📦 Enviando dados do jogo...');
            fetch(this.action, {
                method: 'POST',
                body: formData
            })
            .then(response => {
                console.log('📨 Resposta recebida:', response);
                return response.json();
            })
            .then(data => {
                console.log('📊 Dados da resposta:', data);
                if (data.success) {
                    showGameNotification(data.message || 'Jogo adicionado com sucesso!', 'success');
                    addGameForm.reset();
                    if (imagePreview) imagePreview.style.display = 'none';
                } else {
                    showGameNotification(data.message || 'Erro ao adicionar jogo', 'error');
                }
            })
            .catch(error => {
                console.error('❌ Erro na requisição:', error);
                showGameNotification('Erro de conexão. Tente novamente.', 'error');
            })
            .finally(() => {
                submitGameBtn.innerHTML = originalText;
                submitGameBtn.disabled = false;
            });
        });
    }

    // ========== FUNCIONALIDADES DAS CATEGORIAS EM MASSA ==========
if (bulkAddBtn && categoriesList) {
    bulkAddBtn.addEventListener('click', async function() {
        console.log('🎯 Botão de categorias clicado!');
        
        const categoriesText = categoriesList.value.trim();
        
        if (!categoriesText) {
            showNotification('Por favor, digite pelo menos uma categoria.', 'error');
            return;
        }

        // Dividir por linhas
        const categoriesArray = categoriesText.split('\n')
            .map(cat => cat.trim())
            .filter(cat => cat.length > 0);

        if (categoriesArray.length === 0) {
            showNotification('Nenhuma categoria válida encontrada.', 'error');
            return;
        }

        console.log('📤 Enviando categorias:', categoriesArray);

        // 👇 PRIMEIRO: Testar se a rota existe
        console.log('🔍 Testando rota categories...');
        try {
            const testResponse = await fetch('index.php?route=categories&action=test');
            const testData = await testResponse.text();
            console.log('🧪 Resposta do teste:', testData);
            
            // Verificar se é JSON válido
            try {
                const parsedTest = JSON.parse(testData);
                console.log('✅ Rota test funciona:', parsedTest);
            } catch (e) {
                console.error('❌ Rota test não retorna JSON:', testData.substring(0, 100));
            }
        } catch (error) {
            console.error('❌ Erro ao testar rota:', error);
        }

        // 👇 AGORA: Tentar a rota bulkCreate
        const url = 'index.php?route=categories&action=bulkCreate';
        console.log('🔗 Tentando URL:', url);

        // Mostrar loading
        const originalText = bulkAddBtn.innerHTML;
        bulkAddBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Processando...';
        bulkAddBtn.disabled = true;

        try {
            const response = await fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    categories: categoriesArray
                })
            });

            console.log('📨 Status da resposta:', response.status);
            console.log('📨 Headers:', response.headers);
            
            // 👇 VERIFICAR O QUE ESTÁ SENDO RETORNADO
            const responseText = await response.text();
            console.log('📄 Conteúdo da resposta:', responseText);
            
            if (!response.ok) {
                throw new Error(`Erro HTTP: ${response.status} - ${responseText}`);
            }

            // Tentar parsear como JSON
            let data;
            try {
                data = JSON.parse(responseText);
                console.log('📊 Resposta JSON:', data);
            } catch (e) {
                console.error('❌ Resposta não é JSON válido:', responseText.substring(0, 200));
                throw new Error('Servidor retornou HTML em vez de JSON. Possível erro de rota.');
            }

            if (data.success) {
                showNotification(data.message, 'success');
                categoriesList.value = '';
                
                // Recarregar categorias no select
                if (reloadCategoriesBtn) {
                    setTimeout(() => reloadCategoriesBtn.click(), 1000);
                }
            } else {
                showNotification(data.message, 'error');
            }

        } catch (error) {
            console.error('❌ Erro completo:', error);
            showNotification('Erro: ' + error.message, 'error');
        } finally {
            bulkAddBtn.innerHTML = originalText;
            bulkAddBtn.disabled = false;
        }
    });
} else {
    console.error('❌ Elementos de categorias não encontrados');
}

    // ========== OUTRAS FUNCIONALIDADES ==========
    
    // Preview de imagem
    if (imageUrlInput && imagePreview && previewImage) {
        imageUrlInput.addEventListener('input', function() {
            if (this.value) {
                previewImage.src = this.value;
                imagePreview.style.display = 'block';
                if (imageUploadInput) imageUploadInput.value = '';
            } else {
                imagePreview.style.display = 'none';
            }
        });
    }

    if (imageUploadInput && imagePreview && previewImage) {
        imageUploadInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                if (file.size > 2 * 1024 * 1024) {
                    showGameNotification('A imagem deve ter no máximo 2MB', 'error');
                    this.value = '';
                    return;
                }
                
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImage.src = e.target.result;
                    imagePreview.style.display = 'block';
                    if (imageUrlInput) imageUrlInput.value = '';
                }
                reader.readAsDataURL(file);
            } else {
                imagePreview.style.display = 'none';
            }
        });
    }

    // Reset do formulário
    if (resetFormBtn) {
        resetFormBtn.addEventListener('click', function() {
            if (confirm('Tem certeza que deseja limpar todos os campos?')) {
                if (addGameForm) addGameForm.reset();
                if (imagePreview) imagePreview.style.display = 'none';
                showGameNotification('Formulário limpo com sucesso', 'success');
            }
        });
    }

    // Recarregar categorias
    if (reloadCategoriesBtn && categorySelect) {
        reloadCategoriesBtn.addEventListener('click', async function() {
            const originalText = reloadCategoriesBtn.innerHTML;
            reloadCategoriesBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Carregando...';
            reloadCategoriesBtn.disabled = true;

            try {
                const response = await fetch('index.php?route=categories&action=getAll');
                const categories = await response.json();
                
                categorySelect.innerHTML = '<option value="">Selecione uma categoria</option>';
                
                if (categories && categories.length > 0) {
                    categories.forEach(cat => {
                        const option = document.createElement('option');
                        option.value = cat.id;
                        option.textContent = cat.name;
                        categorySelect.appendChild(option);
                    });
                    showGameNotification('Categorias carregadas com sucesso!', 'success');
                } else {
                    categorySelect.innerHTML = '<option value="">Nenhuma categoria disponível</option>';
                    showGameNotification('Nenhuma categoria encontrada.', 'warning');
                }
            } catch (error) {
                console.error('Erro ao carregar categorias:', error);
                showGameNotification('Erro ao carregar categorias. Verifique a conexão.', 'error');
            } finally {
                reloadCategoriesBtn.innerHTML = '<i class="fas fa-sync-alt me-1"></i>Recarregar Categorias';
                reloadCategoriesBtn.disabled = false;
            }
        });
    }

    console.log('✅ Todos os scripts foram configurados com sucesso!');
});
</script>

<?php require __DIR__ . '/../layout/footer.php'; ?>