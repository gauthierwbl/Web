<?php

require_once 'src/models/Database.php';
require_once 'src/models/CandidatureModel.php';
require_once 'src/models/OffresModel.php'; // Si tu utilises un modèle Offres séparé

class CandidatureController {
    private $model;
    private $offreModel;

    public function __construct() {
        // Se connecter à la base de données
        $pdo = Database::getConnection();
        $this->model = new CandidatureModel($pdo);
        $this->offreModel = new OffresModel($pdo); // Si tu utilises un modèle Offres séparé
    }

    /**
     * Affiche les candidatures avec pagination et recherche
     */
    public function index() {
        // Récupérer le terme de recherche (si applicable)
        $terme = $_GET['terme'] ?? '';
        
        // Pagination
        $pageActuelle = $_GET['page'] ?? 1;
        $pageActuelle = max(1, (int)$pageActuelle); // S'assurer que la page est au moins 1
        $limit = 10; // Nombre d'éléments par page
        $offset = ($pageActuelle - 1) * $limit;
    
        // Récupérer le nombre total de pages
        $totalPages = $this->model->getTotalCandidaturesPages($limit);
    
        // Récupérer toutes les candidatures sans filtre par utilisateur
        $offresCandidaturees = $this->model->getAllCandidatures($terme, $limit, $offset);
    
        // Passer les résultats et la pagination à la vue
        require 'src/views/dashboard/candidatures/gestion-candidatures.php';
    }

    /**
     * Affiche le formulaire de modification de la candidature
     */
    public function edit() {
        // Récupérer l'ID de la candidature et de l'offre
        $id_utilisateur = $_GET['id'] ?? null;
        $id_offre = $_GET['id_o'] ?? null;
    
        // Vérifier si les ID sont valides
        if (!$id_utilisateur || !$id_offre) {
            die("Erreur : ID de la candidature ou de l'offre non spécifié.");
        }
    
        // Récupérer les informations de la candidature, de l'offre et de l'entreprise
        $candidature = $this->model->getCandidatureById($id_utilisateur, $id_offre);
        
        // Récupérer les détails de l'offre et de l'entreprise
        $offre = $this->offreModel->getOffreById($id_offre);  // Si tu as un modèle Offres séparé
        $entreprise = $this->offreModel->getEntrepriseForOffre($id_offre); // Si tu veux aussi l'entreprise
    
        // Vérifier si les données existent
        if (!$candidature || !$offre || !$entreprise) {
            die("Erreur : Candidature, offre ou entreprise non trouvée.");
        }
    
        // Passer les données à la vue
        require 'src/views/dashboard/candidatures/modif-candidature.php';
    }

    /**
     * Mise à jour du statut de la candidature
     */
    public function update() {
        // Récupérer l'ID de la candidature, de l'offre et le nouveau statut
        $id_utilisateur = $_GET['id'] ?? null;
        $id_offre = $_GET['id_o'] ?? null;
        $id_status = $_POST['idStatus'] ?? null; // Le statut sélectionné dans le formulaire

        // Vérifier si les ID sont valides
        if (!$id_utilisateur || !$id_offre || !$id_status) {
            die("Erreur : ID de la candidature, de l'offre ou statut non spécifié.");
        }

        // Mettre à jour le statut de la candidature dans la base de données
        $updated = $this->model->updateCandidatureStatus($id_utilisateur, $id_offre, $id_status);

        // Vérifier si la mise à jour a réussi
        if ($updated) {
            $_SESSION['success'] = "Le statut de la candidature a bien été modifié.";
        } else {
            $_SESSION['error'] = "Erreur lors de la mise à jour du statut.";
        }

        // Rediriger vers la page de gestion des candidatures
        header("Location: index.php?module=candidatures&action=index");
        exit;
    }
  
    
}
?>
