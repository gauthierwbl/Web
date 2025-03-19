<?php

require_once 'Models/DatabaseConnection.php';
require_once 'Models/UserModel.php';

class EtudiantController extends BaseController {
    private $userModel;

    public function __construct() {
        $dbConnection = new DatabaseConnection();
        $dbConnection->connect();
        
        $this->userModel = new UserModel($dbConnection);
        parent::__construct($this->userModel);
    }

    // Affiche la liste des étudiants
    public function index() {
        $etudiants = $this->userModel->getAllEtudiants();
        $this->view->render('/dashboard/etudiants/gestion-etudiants', ['etudiants' => $etudiants]);
    }

    // Crée un nouvel étudiant
    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $_POST;
            $this->userModel->createEtudiant($data);
            header('Location: /dashboard/statistiques');
            exit;
        }
        $this->view->render('/dashboard/etudiants/ajout-etudiants');
    }

    // Modifie un étudiant existant
    public function edit($id) {
        $user = $this->userModel->getEtudiantById($id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $_POST;
            $this->userModel->updateEtudiant($id, $data);
            header('Location: /dashboard/statistiques');
            exit;
        }

        $this->view->render('/dashboard/etudiants/gestion-etudiants', ['user' => $user]);
    }

    // Supprime un étudiant
    public function delete($id) {
        $this->userModel->deleteEtudiant($id);
        header('Location: /dashboard/statistiques');
        exit;
    }

    // Affiche les détails d'un étudiant spécifique
    public function show($id) {
        $user = $this->userModel->getEtudiantById($id);
        $this->view->render('/dashboard/etudiants/gestion-etudiants', ['user' => $user]);
    }
}
