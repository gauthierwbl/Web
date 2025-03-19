<?php

require_once 'Models/DatabaseConnection.php';
require_once 'Models/UserModel.php';

class PiloteController extends BaseController {
    private $userModel;

    public function __construct() {
        // Crée une instance de DatabaseConnection et connecte-la
        $dbConnection = new DatabaseConnection();
        $dbConnection->connect();
        
        // Crée une instance du modèle UserModel et passe la connexion à la base de données
        $this->userModel = new UserModel($dbConnection);
        
        // Appelle le constructeur parent avec le modèle UserModel
        parent::__construct($this->userModel);
    }

    // Affiche la liste des pilotes
    public function index() {
        $pilotes = $this->userModel->getAllPilotes();
        $this->view->render('/dashboard/pilotes/gestion-pilotes', ['pilotes' => $pilotes]);
    }

    // Crée un nouveau pilote
    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $_POST;
            $this->userModel->createPilote($data);
            header('Location: /dashboard/statistiques');
            exit;
        }
        $this->view->render('/dashboard/pilotes/ajout-pilotes');
    }

    // Modifie un pilote existant
    public function edit($id) {
        $user = $this->userModel->getPiloteById($id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $_POST;
            $this->userModel->updatePilote($id, $data);
            header('Location: /dashboard/statistiques');
            exit;
        }

        $this->view->render('/dashboard/pilotes/gestion-pilotes', ['user' => $user]);
    }

    // Supprime un pilote
    public function delete($id) {
        $this->userModel->deletePilote($id);
        header('Location: /dashboard/statistiques');
        exit;
    }

    // Affiche les détails d'un pilote spécifique
    public function show($id) {
        $user = $this->userModel->getPiloteById($id);
        $this->view->render('/dashboard/pilotes/gestion-pilotes', ['user' => $user]);
    }
}