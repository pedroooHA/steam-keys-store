<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nexus Keys</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
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
            line-height: 1.4;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        main {
            flex: 1;
        }

        /* Header Styles */
        .custom-header {
            background: #ffffff;
            border-bottom: 1px solid #e0e0e0;
            padding: 0;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .container-fluid {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .navbar-brand.logo {
            font-size: 1.4rem;
            font-weight: 600;
            color: #000000;
            letter-spacing: -0.3px;
            padding: 16px 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .navbar-brand.logo i {
            font-size: 1.6rem;
            color: #000000;
        }

        .navbar-nav .nav-link {
            color: #1d1d1f !important;
            font-weight: 500;
            padding: 12px 16px !important;
            border-radius: 8px;
            margin: 0 4px;
            transition: all 0.2s ease;
            font-size: 0.95rem;
        }

        .navbar-nav .nav-link:hover {
            background: #f5f5f7;
            color: #000000 !important;
        }

        .search-form {
            position: relative;
            margin: 0 15px;
        }

        .search-form .form-control {
            padding: 10px 16px 10px 40px;
            background: #fafafa;
            border: 1px solid #e0e0e0;
            border-radius: 10px;
            font-size: 0.9rem;
            color: #1d1d1f;
            transition: all 0.2s ease;
            outline: none;
            width: 280px;
        }

        .search-form .form-control:focus {
            border-color: #000000;
            background: #ffffff;
            box-shadow: 0 0 0 3px rgba(0, 0, 0, 0.05);
        }

        .search-form .search-icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #666666;
            font-size: 0.95rem;
        }

        .search-form .btn {
            position: absolute;
            right: 4px;
            top: 50%;
            transform: translateY(-50%);
            background: transparent;
            border: none;
            color: #666666;
            padding: 6px 10px;
            border-radius: 6px;
            transition: all 0.2s ease;
        }

        .search-form .btn:hover {
            background: #f0f0f0;
            color: #000000;
        }

        .cart-btn {
            background: #000000 !important;
            color: white !important;
            border: none;
            border-radius: 10px;
            padding: 10px 14px !important;
            font-size: 0.9rem;
            font-weight: 500;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            gap: 6px;
            text-decoration: none;
        }

        .cart-btn:hover {
            background: #333333 !important;
            color: white !important;
            transform: translateY(-1px);
        }

        /* Footer Styles */
        .main-footer {
            background: #ffffff;
            border-top: 1px solid #e0e0e0;
            padding: 30px 0;
            margin-top: auto;
        }

        .main-footer .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .main-footer p {
            color: #86868b;
            font-size: 0.9rem;
            margin: 0;
        }

        .social-links {
            display: flex;
            gap: 15px;
        }

        .social-links a {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            background: #fafafa;
            border: 1px solid #e0e0e0;
            border-radius: 10px;
            color: #000000;
            text-decoration: none;
            transition: all 0.2s ease;
            font-size: 1rem;
        }

        .social-links a:hover {
            background: #000000;
            color: #ffffff;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        /* Login Form Styles */
        .login-container {
            width: 100%;
            max-width: 400px;
            background: #ffffff;
            border-radius: 16px;
            padding: 40px 35px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            position: relative;
            overflow: hidden;
            border: 1px solid #f0f0f0;
            margin: 40px auto;
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

        .login-header {
            text-align: center;
            margin-bottom: 25px;
        }

        .login-header h2 {
            font-size: 1.3rem;
            font-weight: 600;
            margin-bottom: 6px;
            color: #000000;
        }

        .login-header p {
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

        .remember-forgot {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 12px;
            font-size: 0.85rem;
        }

        .remember {
            display: flex;
            align-items: center;
            gap: 6px;
            color: #1d1d1f;
        }

        .remember input {
            width: 16px;
            height: 16px;
            accent-color: #000000;
        }

        .forgot {
            color: #000000;
            text-decoration: none;
        }

        .forgot:hover {
            text-decoration: underline;
        }

        /* Responsive */
        @media (max-width: 991px) {
            .search-form {
                margin: 10px 0;
                width: 100%;
            }
            
            .search-form .form-control {
                width: 100%;
            }
            
            .navbar-nav .nav-link {
                margin: 2px 0;
            }
            
            .cart-btn {
                margin: 10px 0;
                justify-content: center;
            }
        }

        @media (max-width: 768px) {
            .container-fluid {
                padding: 0 15px;
            }
            
            .navbar-brand.logo {
                font-size: 1.3rem;
            }
            
            .main-footer .container {
                flex-direction: column;
                gap: 20px;
                text-align: center;
            }
        }

        @media (max-width: 480px) {
            .login-container {
                padding: 35px 25px;
                border-radius: 14px;
            }
            
            .logo h1 {
                font-size: 1.5rem;
            }
            
            .login-header h2 {
                font-size: 1.2rem;
            }
            
            .form-control {
                padding: 12px 12px 12px 38px;
            }
        }
    </style>
</head>
<body>

    <footer class="main-footer">
        <div class="container">
            <p>&copy; 2025 Nexus Keys. Todos os direitos reservados.</p>
            <div class="social-links">
                <a href="#"><i class="fab fa-facebook-f"></i></a>
                <a href="#"><i class="fab fa-twitter"></i></a>
                <a href="#"><i class="fab fa-instagram"></i></a>
                <a href="#"><i class="fab fa-discord"></i></a>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>