<?php
class AuthController {
    public function showLogin(){
        require __DIR__ . '/../views/auth/login.php';
    }

    public function showRegister(){
        require __DIR__ . '/../views/auth/register.php';
    }

    public function login(){
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        $user = User::findByEmail($email);

        if(!$user || !password_verify($password, $user->getPasswordHash())){
            $_SESSION['flash'] = 'Credenciais inválidas';
            header('Location: index.php?route=login');
            exit;
        }

        // 🔹 Armazena dados do usuário na sessão
        $_SESSION['user_id'] = $user->getId();
        $_SESSION['username'] = $user->getName();   
        $_SESSION['role'] = $user->getRole();

        header('Location: index.php');
    }

    public function register(){
        $name = $_POST['name'] ?? '';
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        if(User::findByEmail($email)){
            $_SESSION['flash'] = 'Email já cadastrado';
            header('Location: index.php?route=register');
            exit;
        }

        $u = new User();
        $u->setName($name);
        $u->setEmail($email);
        $u->setPasswordHash(password_hash($password, PASSWORD_DEFAULT));
        $u->setRole('user');
        $u->save();

        $_SESSION['user_id'] = $u->getId();
        $_SESSION['username'] = $u->getName();
        $_SESSION['role'] = $u->getRole();

        header('Location: index.php');
    }

    public function logout(){
        session_destroy();
        header('Location: index.php');
        exit;
    }
}
