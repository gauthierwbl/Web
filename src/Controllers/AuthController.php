<?php

require_once 'Models/DatabaseConnection.php';
require_once 'Models/UserModel.php';

class AuthController extends BaseController {

    // Déclare la propriété pour le modèle
    private $userModel;

    // Constructeur pour initialiser le modèle
    public function __construct() {
        // Crée une instance de DatabaseConnection
        $databaseConnection = new DatabaseConnection();
        // Crée une instance de UserModel avec la connexion à la base de données
        $this->userModel = new UserModel($databaseConnection);
        parent::__construct($this->userModel);
    }

    public function index() {
        // Affiche la page de login
        $this->view->render('auth/login');
    }

    public function login() {
        // Logic de connexion
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Sécurisation des données
            $username = htmlspecialchars($_POST['username']);
            $password = htmlspecialchars($_POST['password']);
            
            // Utilisation de la méthode authenticate du modèle
            $user = $this->userModel->authenticate($username, $password);
            if ($user) {
                // Démarrage de la session si elle n'est pas déjà démarrée
                if (session_status() === PHP_SESSION_NONE) {
                    session_start();
                }
                $_SESSION['user'] = $user;
                header('Location: /dashboard');
                exit;
            } else {
                // Affiche un message d'erreur si les identifiants sont invalides
                $this->view->render('auth/login', ['error' => 'Invalid credentials']);
            }
        }
    }

    public function logout() {
        // Logic de déconnexion
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        unset($_SESSION['user']);
        header('Location: /login');
        exit;
    }

    public function create() {
        // Logic pour enregistrer un nouvel utilisateur (si nécessaire)
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = htmlspecialchars($_POST['username']);
            $password = htmlspecialchars($_POST['password']);
            // Implémenter la logique pour enregistrer l'utilisateur, par exemple :
            // $this->userModel->createUser($username, $password);
        }
    }

    public function edit($id) {
        // Logic pour éditer un utilisateur
        // Implémenter la logique de mise à jour
    }

    public function delete($id) {
        // Logic pour supprimer un utilisateur
        // Implémenter la logique de suppression
    }

    public function show($id) {
        // Affiche le profil d'un utilisateur
        $user = $this->userModel->getUserById($id);
        $this->view->render('auth/show', ['user' => $user]);
    }
}
