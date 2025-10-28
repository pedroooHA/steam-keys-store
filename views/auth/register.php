<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar • Sistema</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
        }

        body {
            background-color: #fefefe;
            color: #1d1d1f;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            line-height: 1.4;
        }

        .register-container {
            width: 100%;
            max-width: 400px;
            background: #ffffff;
            border-radius: 16px;
            padding: 40px 35px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            position: relative;
            overflow: hidden;
            border: 1px solid #f0f0f0;
        }

        .logo {
            text-align: center;
            margin-bottom: 30px;
        }

        .logo i {
            font-size: 2.2rem;
            color: #000000;
            margin-bottom: 12px;
        }

        .logo h1 {
            font-size: 1.6rem;
            font-weight: 600;
            color: #000000;
            letter-spacing: -0.3px;
        }

        .register-header {
            text-align: center;
            margin-bottom: 25px;
        }

        .register-header h2 {
            font-size: 1.3rem;
            font-weight: 600;
            margin-bottom: 6px;
            color: #000000;
        }

        .register-header p {
            color: #86868b;
            font-size: 0.9rem;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            margin-bottom: 6px;
            font-weight: 500;
            color: #000000;
            font-size: 0.9rem;
        }

        .input-container {
            position: relative;
        }

        .form-control {
            width: 100%;
            padding: 14px 14px 14px 42px;
            background: #fafafa;
            border: 1px solid #e0e0e0;
            border-radius: 10px;
            font-size: 0.95rem;
            color: #1d1d1f;
            transition: all 0.2s ease;
            outline: none;
        }

        .form-control:focus {
            border-color: #000000;
            background: #ffffff;
            box-shadow: 0 0 0 3px rgba(0, 0, 0, 0.05);
        }

        .input-icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #666666;
            font-size: 1rem;
        }

        .btn-primary {
            width: 100%;
            padding: 14px;
            background: #000000;
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 0.95rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
            margin-top: 8px;
        }

        .btn-primary:hover {
            background: #333333;
        }

        .btn-primary:active {
            transform: scale(0.98);
        }

        .register-footer {
            text-align: center;
            margin-top: 25px;
            font-size: 0.85rem;
            color: #86868b;
        }

        .register-footer a {
            color: #000000;
            text-decoration: none;
            font-weight: 500;
        }

        .register-footer a:hover {
            text-decoration: underline;
        }

        .divider {
            display: flex;
            align-items: center;
            margin: 20px 0;
            color: #86868b;
        }

        .divider::before, .divider::after {
            content: '';
            flex: 1;
            border-bottom: 1px solid #e0e0e0;
        }

        .divider span {
            padding: 0 12px;
            font-size: 0.8rem;
        }

        .social-register {
            display: flex;
            justify-content: center;
            gap: 12px;
            margin-top: 18px;
        }

        .social-btn {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #fafafa;
            border: 1px solid #e0e0e0;
            color: #000000;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .social-btn:hover {
            background: #f0f0f0;
            border-color: #cccccc;
        }

        .terms {
            margin-top: 15px;
            font-size: 0.8rem;
            color: #86868b;
            text-align: center;
        }

        .terms a {
            color: #000000;
            text-decoration: none;
        }

        .terms a:hover {
            text-decoration: underline;
        }

        @media (max-width: 480px) {
            .register-container {
                padding: 35px 25px;
                border-radius: 14px;
            }
            
            .logo h1 {
                font-size: 1.5rem;
            }
            
            .register-header h2 {
                font-size: 1.2rem;
            }
            
            .form-control {
                padding: 12px 12px 12px 38px;
            }
        }
    </style>
</head>
<body>
    <div class="register-container">
        <div class="logo">
            <i class="fas fa-gem"></i>
            <h1>BlackLabel</h1>
        </div>
        
        <div class="register-header">
            <h2>Criar conta</h2>
            <p>Cadastre-se no sistema</p>
        </div>
        
        <form method="post" action="index.php?route=register">
            <div class="form-group">
                <label for="name" class="form-label">Nome</label>
                <div class="input-container">
                    <span class="input-icon"><i class="far fa-user"></i></span>
                    <input id="name" class="form-control" type="text" name="name" placeholder="Seu nome completo" required>
                </div>
            </div>
            
            <div class="form-group">
                <label for="email" class="form-label">E-mail</label>
                <div class="input-container">
                    <span class="input-icon"><i class="far fa-envelope"></i></span>
                    <input id="email" class="form-control" type="email" name="email" placeholder="seu@email.com" required>
                </div>
            </div>
            
            <div class="form-group">
                <label for="password" class="form-label">Senha</label>
                <div class="input-container">
                    <span class="input-icon"><i class="fas fa-lock"></i></span>
                    <input id="password" class="form-control" type="password" name="password" placeholder="••••••••" required>
                </div>
            </div>
            
            <button type="submit" class="btn-primary">Criar conta</button>
        </form>
        
        <div class="divider">
            <span>ou</span>
        </div>
        
        <div class="social-register">
            <button class="social-btn">
                <i class="fab fa-apple"></i>
            </button>
            <button class="social-btn">
                <i class="fab fa-google"></i>
            </button>
            <button class="social-btn">
                <i class="fab fa-microsoft"></i>
            </button>
        </div>
        
        <div class="terms">
            Ao criar uma conta, você concorda com nossos <a href="#">Termos de Serviço</a> e <a href="#">Política de Privacidade</a>.
        </div>
        
        <div class="register-footer">
            <p>Já tem uma conta? <a href="http://localhost/steam-keys-store/public/index.php?route=login">Fazer login</a></p>
        </div>
    </div>
</body>
</html>