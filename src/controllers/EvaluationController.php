<?php
require_once 'src/models/Database.php';
require_once 'src/models/EvaluationModel.php';

class EvaluationController {
    private $model;
    private $pdo;

    public function __construct() {
        $this->pdo = Database::getConnection();
        $this->model = new EvaluationModel($this->pdo);
    }

    // Afficher les evaluation avec pagination
    public function index() {
        $evaluationParPage = 5; // Nombre d'evaluation par page
        $totalPages = $this->model->getTotalPages($evaluationParPage); // Calcul des pages

        $pageActuelle = 1;
        if (isset($_GET["page"])) {
            if (!ctype_digit($_GET["page"]) || (int)$_GET["page"] < 1) {
                die("Erreur : Numéro de page invalide.");
            }
            $pageActuelle = min((int)$_GET["page"], $totalPages);
        }
        // Récupérer les evaluation pour la page actuelle
        $evaluationAffichees = $this->model->getEvaluation($pageActuelle, $evaluationParPage);
        $totalPages = $this->model->getTotalPages($evaluationParPage);
        require 'src/views/evaluation.php'; // Passer les données à la vue
    }
/*
    // Afficher le formulaire de création d'evaluation
    public function create() {
        require 'src/views/dashboard/evaluation/ajout-evaluation.php';
    }*/

    // Enregistrer une nouvelle evaluation
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_utilisateur = isset($_POST['id_utilisateur']) ? (int)$_POST['id_utilisateur'] : null;
            $id_entreprise = isset($_POST['id_entreprise']) ? (int)$_POST['id_entreprise'] : null;
            $note = isset($_POST['note']) ? (int)$_POST['note'] : null;
    
            if (!$id_utilisateur || !$id_entreprise || !is_numeric($note) || $note < 0 || $note > 20) {
                die("Erreur : Données invalides. La note doit être comprise entre 0 et 20.");
            }
    
            if ($this->model->create($note, $id_utilisateur, $id_entreprise)) {
                // Redirection vers la page de l'entreprise avec un message de succès
                $etoiles = $this->model->etoiles($note);
                //header("Location: détail-offre.php?id=$id_entreprise&etoiles=$etoiles&success=1");
                header("Location: détail-offre.php?id=" . $id_entreprise . "&etoiles=" . $this->model->etoiles($note) . "&success=1");
                die("Redirection vers : détail-offre.php?id=" . $id_entreprise . "&etoiles=" . $this->model->etoiles($note) . "&success=1");
            } else {
                // En cas d'erreur
                header("Location: index.php?module=evaluation&action=index&error=1");
            }
            exit;
        }
    }

    // Afficher les évaluations d'une entreprise
    public function showEntrepriseEvaluations($id_entreprise) {
        $evaluations = $this->model->getByEntrepriseId($id_entreprise);
        $moyenneNote = $this->model->getMoyenneEntreprise($id_entreprise);
        $nombreEtoiles = $this->model->etoiles($moyenneNote);
        require 'src/views/evaluation/entreprise_evaluations.php';
    }
}
?>