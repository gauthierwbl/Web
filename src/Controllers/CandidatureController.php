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

    // Méthode pour afficher la liste des candidatures
    public function index() {
        // Récupère toutes les candidatures
        $candidatures = $this->candidatureModel->getAllCandidatures();
        // Utilise la méthode render pour afficher la vue avec les candidatures
        $this->view->render('/candidature', ['candidatures' => $candidatures]);
    }

    // Méthode pour créer une nouvelle candidature
    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $_POST; // Récupère les données du formulaire
            $this->candidatureModel->createCandidature($data); // Crée la candidature
            header('Location: /dashboard/candidatures'); // Redirige vers la liste des candidatures
            exit; // Assure que le script s'arrête après la redirection
        }
        // Affiche le formulaire de création de candidature
        $this->view->render('/postuler');
    }

    // Méthode pour éditer une candidature
    public function edit($id) {
        // Récupère la candidature à modifier
        $candidature = $this->candidatureModel->getCandidatureById($id);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $_POST; // Récupère les données mises à jour
            $this->candidatureModel->updateCandidature($id, $data); // Met à jour la candidature
            header('Location: /dashboard/candidatures'); // Redirige vers la liste des candidatures
            exit;
        }
        // Affiche le formulaire d'édition de la candidature
        $this->view->render('/dashboard/candidatures/modif-candidature', ['candidature' => $candidature]);
    }

    // Méthode pour supprimer une candidature
    public function delete($id) {
        // Supprime la candidature
        $this->candidatureModel->deleteCandidature($id);
        header('Location: /dashboard/candidatures'); // Redirige vers la liste des candidatures
        exit;
    }

    // Méthode pour afficher les détails d'une candidature
    public function show($id) {
        // Récupère les détails de la candidature
        $candidature = $this->candidatureModel->getCandidatureById($id);
        // Affiche la vue avec les détails de la candidature
        $this->view->render('/dashboard/candidatures/gestion-candidatures', ['candidature' => $candidature]);
    }
}
