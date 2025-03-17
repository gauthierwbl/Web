<?php

require_once 'Models/DatabaseConnection.php';
require_once 'Models/CandidatureModel.php';

class CandidatureController extends BaseController {

    // Déclare la propriété pour le modèle
    private $candidatureModel;

    // Constructeur pour initialiser le modèle
    public function __construct() {
        // Crée une instance de DatabaseConnection
        $databaseConnection = new DatabaseConnection();
        // Crée une instance de CandidatureModel avec la connexion à la base de données
        $this->candidatureModel = new CandidatureModel($databaseConnection);
        parent::__construct($this->candidatureModel);
    }

    public function index() {
        // Récupère toutes les candidatures
        $candidatures = $this->candidatureModel->getAllCandidatures();
        // Affiche la liste des candidatures
        $this->view->render('candidature/list', ['candidatures' => $candidatures]);
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $_POST; // Récupère les données du formulaire
            $this->candidatureModel->createCandidature($data); // Crée la candidature
            header('Location: /candidatures'); // Redirige vers la liste des candidatures
            exit;
        }
        $this->view->render('candidature/create'); // Affiche le formulaire de création
    }

    public function edit($id) {
        // Récupère la candidature à modifier
        $candidature = $this->candidatureModel->getCandidatureById($id);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $_POST; // Récupère les données mises à jour
            $this->candidatureModel->updateCandidature($id, $data); // Met à jour la candidature
            header('Location: /candidatures'); // Redirige vers la liste des candidatures
            exit;
        }
        // Affiche le formulaire d'édition
        $this->view->render('candidature/edit', ['candidature' => $candidature]);
    }

    public function delete($id) {
        // Supprime la candidature
        $this->candidatureModel->deleteCandidature($id);
        header('Location: /candidatures'); // Redirige vers la liste des candidatures
        exit;
    }

    public function show($id) {
        // Affiche la candidature avec les détails
        $candidature = $this->candidatureModel->getCandidatureById($id);
        $this->view->render('candidature/show', ['candidature' => $candidature]);
    }
}
