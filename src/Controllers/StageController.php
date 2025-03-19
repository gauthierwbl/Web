<?php

require_once 'Models/DatabaseConnection.php';
require_once 'Models/StageModel.php';

class StageController extends BaseController {
    private $stageModel;

    // Constructeur pour initialiser la connexion à la base de données et l'instance du modèle
    public function __construct() {
        // Crée une instance de DatabaseConnection et connecte-la
        $dbConnection = new DatabaseConnection();
        $dbConnection->connect();
        
        // Crée une instance du modèle StageModel en lui passant la connexion à la base de données
        $this->stageModel = new StageModel($dbConnection);
        parent::__construct($this->stageModel); // Passe l'instance du modèle au parent
    }

    // Affiche la liste des stages
    public function index() {
        $stages = $this->stageModel->getAllStages();
        $this->view->render('/offres', ['stages' => $stages]);  // Affiche la vue pour la liste des stages
    }

    // Crée un nouveau stage
    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $_POST; // Récupère les données du formulaire
            $this->stageModel->createStage($data); // Crée le stage
            header('Location: /dashboard/offres'); // Redirige vers la liste des stages
            exit; // Arrête l'exécution du script après la redirection
        }
        // Affiche le formulaire de création
        $this->view->render('/dashboard/offres/ajout-offre');
    }

    // Modifie un stage existant
    public function edit($id) {
        $stage = $this->stageModel->getStageById($id);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $_POST; // Récupère les données mises à jour
            $this->stageModel->updateStage($id, $data); // Met à jour le stage
            header('Location: /dashboard/offres'); // Redirige vers la liste des stages
            exit; // Arrête l'exécution du script après la redirection
        }
        // Affiche le formulaire d'édition avec les données du stage
        $this->view->render('/dashboard/offres/modif-offre', ['stage' => $stage]);
    }

    // Supprime un stage
    public function delete($id) {
        $this->stageModel->deleteStage($id);
        header('Location: /dashboard/offres'); // Redirige vers la liste des stages
        exit; // Arrête l'exécution du script après la redirection
    }

    // Affiche les détails d'un stage
    public function show($id) {
        $stage = $this->stageModel->getStageById($id);
        $this->view->render('/détail-offre', ['stage' => $stage]);
    }
}
