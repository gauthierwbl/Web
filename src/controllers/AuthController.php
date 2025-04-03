<?php

// Inclusion du modèle utilisateur pour interagir avec la base de données
require_once 'src/models/UserModel.php';

class AuthController {
    private $userModel;

    // Constructeur qui initialise le modèle utilisateur avec une connexion PDO
    public function __construct($pdo) {
        $this->userModel = new UserModel(pdo: $pdo);
    }

    // Affiche le formulaire de connexion, avec un message d'erreur éventuel
    public function showLoginForm() {
        if (isset($_SESSION['user'])) {
            // Si l'utilisateur est déjà connecté, redirige vers la page principale
            header('Location: index.php?module=entreprises&action=index');
            exit;
        }
    
        $error = isset($_SESSION['auth_error']) ? $_SESSION['auth_error'] : null;
        // Nettoyer le message d'erreur après l'avoir récupéré
        unset($_SESSION['auth_error']);
        
        include 'src/views/connexion.php'; // Affiche la vue de connexion
    }
    
    // Gère la logique de connexion de l'utilisateur
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $login = $_POST['login'] ?? '';
            $password = $_POST['password'] ?? '';
    
            // Recherche de l'utilisateur dans la BDD
            $user = $this->userModel->findUserByUsername($login);
    
            if ($user && password_verify($password, $user['mot_de_passe'])) {
                // Utilisateur authentifié, on le met dans la session
                $_SESSION['user'] = $user;
                $_SESSION['user']['id_role'] = $user['id_role'];
                // Redirection vers la page principale
                header('Location: index.php?module=entreprises&action=index');
                exit;
            } else {
                // Si utilisateur ou mot de passe incorrect
                $_SESSION['auth_error'] = "Identifiants incorrects.";
                header('Location: index.php?module=auth&action=showLoginForm');
                exit;
            }
        } else {
            // Si ce n'est pas une requête POST, rediriger vers le formulaire
            header('Location: index.php?module=auth&action=showLoginForm');
            exit;
        }
    }
    
    // Gère la déconnexion de l'utilisateur
    public function logout() {
        // Destruction des données de session
        session_unset();
        session_destroy();
        
        // Démarrer une nouvelle session pour pouvoir y stocker des messages flash
        session_start();
        
        // Redirection vers la page de connexion
        header('Location: index.php?module=auth&action=showLoginForm');
        exit;
    }
    
    // Permet à un utilisateur de continuer en tant qu'invité
   // Permet à un utilisateur de continuer en tant qu'invité
public function guestAccess() {
    // Connexion automatique avec les identifiants d'un utilisateur invité
    $login = 'invite'; // Identifiant de l'invité
    $password = 'password'; // Remplacer par le mot de passe en dur de l'invité, si nécessaire

    // Recherche de l'utilisateur dans la BDD
    $user = $this->userModel->findUserByUsername($login);
    
    // Vérifier si l'utilisateur existe et si le mot de passe correspond
    if ($user && password_verify($password, $user['mot_de_passe'])) {
        // Utilisateur authentifié, on le met dans la session
        $_SESSION['user'] = $user;
        $_SESSION['user']['id_role'] = $user['id_role'];
        // Redirection vers la page principale
        header('Location: index.php?module=entreprises&action=index&guest=true');
        exit;
    } else {
        // Si l'utilisateur invité n'est pas trouvé ou mot de passe incorrect
        $_SESSION['auth_error'] = "Erreur lors de la connexion en tant qu'invité.";
        header('Location: index.php?module=auth&action=showLoginForm');
        exit;
    }
}

    
    // Affiche le formulaire d'inscription (si nécessaire)
    public function showRegistrationForm() {
        $error = isset($_SESSION['reg_error']) ? $_SESSION['reg_error'] : null;
        // Nettoyer le message d'erreur après l'avoir récupéré
        unset($_SESSION['reg_error']);
        
        include 'src/views/register.php';
    }
    
    // Gère l'inscription d'un nouvel utilisateur (si nécessaire)
    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';
    
            // Vérifie si l'utilisateur existe déjà
            if ($this->userModel->findUserByUsername($username)) {
                $_SESSION['reg_error'] = "Cet utilisateur existe déjà.";
                header('Location: index.php?module=auth&action=showRegistrationForm');
                exit;
            }
    
            // Hachage sécurisé du mot de passe
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    
            // Création de l'utilisateur
            if ($this->userModel->createUser($username, $hashedPassword)) {
                $_SESSION['auth_success'] = "Compte créé avec succès. Veuillez vous connecter.";
                header('Location: index.php?module=auth&action=showLoginForm');
                exit;
            } else {
                $_SESSION['reg_error'] = "Erreur lors de la création du compte.";
                header('Location: index.php?module=auth&action=showRegistrationForm');
                exit;
            }
        } else {
            header('Location: index.php?module=auth&action=showRegistrationForm');
            exit;
        }
    }
}