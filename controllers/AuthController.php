<?php

require_once 'models/UserModel.php';

class AuthController {
    private $userModel;

    public function __construct($pdo) {
        $this->userModel = new UserModel($pdo);
    }

    public function showLoginForm() {
        $error = isset($_GET['error']) ? $_GET['error'] : null;
        include 'views/login.php';
    }
    
    
    

    public function login() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }        

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';

            $user = $this->userModel->findUserByUsername($username);

            if ($user) {
                if ($password === $user['password']) {
                    $_SESSION['user'] = $user;
                    header('Location: index.php?action=index'); // Redirige vers la page des entreprises
                    exit;
                } else {
                    // Mot de passe incorrect
                    header('Location: index.php?action=login&error=1');
                    exit;
                }
            } else {
                // Utilisateur non trouvé
                header('Location: index.php?action=login&error=1');
                exit;
            }
        } else {
            header('Location: index.php?action=login');
            exit;
        }
    }
}
