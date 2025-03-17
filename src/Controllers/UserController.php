<?php

require_once 'Models/DatabaseConnection.php';
require_once 'Models/UserModel.php';

class UserController extends BaseController {
    private $userModel;

    // Constructeur pour initialiser les modèles et les connecter à la base de données
    public function __construct() {
        // Crée une instance de DatabaseConnection et connecte-la
        $dbConnection = new DatabaseConnection();
        $dbConnection->connect();
        
        // Crée une instance du modèle UserModel et passe la connexion à la base de données
        $this->userModel = new UserModel($dbConnection);
        
        // Appelle le constructeur parent avec le modèle UserModel
        parent::__construct($this->userModel);
    }

    // Affiche la liste des utilisateurs
    public function index() {
        // Récupère tous les utilisateurs depuis le modèle
        $users = $this->userModel->getAllUsers();
        // Rendu de la vue avec les utilisateurs
        $this->view->render('user/list', ['users' => $users]);
    }

    // Crée un nouvel utilisateur
    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $_POST;
            // Crée un utilisateur avec les données du formulaire
            $this->userModel->createUser($data);
            // Redirige vers la liste des utilisateurs après la création
            header('Location: /users');
        }
        // Rendu de la vue de création d'utilisateur
        $this->view->render('user/create');
    }

    // Modifie un utilisateur existant
    public function edit($id) {
        $user = $this->userModel->getUserById($id);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $_POST;
            // Met à jour l'utilisateur avec les nouvelles données
            $this->userModel->updateUser($id, $data);
            // Redirige vers la liste des utilisateurs après la mise à jour
            header('Location: /users');
        }
        // Rendu de la vue de modification de l'utilisateur
        $this->view->render('user/edit', ['user' => $user]);
    }

    // Supprime un utilisateur
    public function delete($id) {
        // Supprime l'utilisateur par son ID
        $this->userModel->deleteUser($id);
        // Redirige vers la liste des utilisateurs après la suppression
        header('Location: /users');
    }

    // Affiche les détails d'un utilisateur spécifique
    public function show($id) {
        // Récupère les détails de l'utilisateur par son ID
        $user = $this->userModel->getUserById($id);
        // Rendu de la vue avec les détails de l'utilisateur
        $this->view->render('user/show', ['user' => $user]);
    }
}
