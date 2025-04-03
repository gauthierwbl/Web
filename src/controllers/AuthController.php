<?php

// Inclusion du modèle utilisateur pour interagir avec la base de données
require_once 'src/models/UserModel.php';

class AuthController {
    private $userModel;

    // Constructeur qui initialise le modèle utilisateur avec une connexion PDO
    public function __construct($pdo) {
        $this->userModel = new UserModel($pdo);
        
    }

    // Affiche le formulaire de connexion, avec un message d'erreur éventuel
    public function showLoginForm() {
        $error = isset($_GET['error']) ? $_GET['error'] : null;
        include 'src/views/connexion.php'; // Affiche la vue login.php
    }

    // Gère la logique de connexion de l'utilisateur
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $login = $_POST['login'] ?? '';
            $password = $_POST['password'] ?? '';
    
            // Récupère l'utilisateur via son username
            $user = $this->userModel->findUserByUsername($login);
            var_dump($user);
            var_dump(password_verify($password, $user['password']));

            if ($user) {
                // Vérification sécurisée du mot de passe haché
                if (password_verify($password, $user['mot_de_passe'])) {
                    $_SESSION['user'] = $user;
                    header('Location: index.php?module=entreprises&action=index');
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
    

    // Connexion automatique en tant qu'invité (id_role = 4)
    public function loginAsGuest() {
        // Cherche un utilisateur avec le rôle invité
        $guestUser = $this->userModel->findGuestUser(); // méthode à créer dans le modèle

        if ($guestUser) {
            $_SESSION['user'] = $guestUser;
            header('Location: index.php?action=index'); // Redirige vers la page principale
            exit;
        } else {
            header('Location: index.php?action=login&error=guest');
            exit;
        }
    }
    // Affiche le formulaire d'inscription
public function showRegistrationForm() {
    $error = isset($_GET['error']) ? $_GET['error'] : null;
    include 'views/register.php';
}

// Gère l'inscription d'un nouvel utilisateur
public function register() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';

        // Vérifie si l'utilisateur existe déjà
        if ($this->userModel->findUserByUsername($username)) {
            header('Location: index.php?action=register&error=user_exists');
            exit;
        }

        // Hachage sécurisé du mot de passe
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Création de l'utilisateur
        if ($this->userModel->createUser($username, $hashedPassword)) {
            header('Location: index.php?action=login');
            exit;
        } else {
            header('Location: index.php?action=register&error=registration_failed');
            exit;
        }
    } else {
        header('Location: index.php?action=register');
        exit;
    }
}

}
