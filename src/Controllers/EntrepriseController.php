<?php

require_once 'Models/DatabaseConnection.php';
require_once 'Models/EntrepriseModel.php';

class EntrepriseController extends BaseController {
    private $entrepriseModel;

    // Constructeur pour initialiser la connexion à la base de données et l'instance du modèle
    public function __construct() {
        // Crée une instance de DatabaseConnection et connecte-la
        $dbConnection = new DatabaseConnection();
        $dbConnection->connect();
        
        // Crée une instance du modèle EntrepriseModel en lui passant la connexion à la base de données
        $this->entrepriseModel = new EntrepriseModel($dbConnection);
        parent::__construct($this->entrepriseModel); // Passe l'instance du modèle au parent
    }

    // Affiche la liste des entreprises
    public function index() {
        $entreprises = $this->entrepriseModel->getAllEntreprises();
        $this->view->render('entreprise/list', ['entreprises' => $entreprises]);
    }

    // Crée une nouvelle entreprise
    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $_POST; // Récupère les données du formulaire
            $this->entrepriseModel->createEntreprise($data); // Crée l'entreprise
            header('Location: /entreprises'); // Redirige vers la liste des entreprises
            exit;
        }
        $this->view->render('entreprise/create'); // Affiche le formulaire de création
    }

    // Modifie une entreprise existante
    public function edit($id) {
        $entreprise = $this->entrepriseModel->getEntrepriseById($id);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $_POST; // Récupère les données mises à jour
            $this->entrepriseModel->updateEntreprise($id, $data); // Met à jour l'entreprise
            header('Location: /entreprises'); // Redirige vers la liste des entreprises
            exit;
        }
        // Affiche le formulaire d'édition
        $this->view->render('entreprise/edit', ['entreprise' => $entreprise]);
    }

    // Supprime une entreprise
    public function delete($id) {
        $this->entrepriseModel->deleteEntreprise($id);
        header('Location: /entreprises'); // Redirige vers la liste des entreprises
        exit;
    }

    // Affiche les détails d'une entreprise
    public function show($id) {
        $entreprise = $this->entrepriseModel->getEntrepriseById($id);
        $this->view->render('entreprise/show', ['entreprise' => $entreprise]);
    }
}
