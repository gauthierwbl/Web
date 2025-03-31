<?php
require_once 'src/models/Database.php';
require_once 'src/models/EntreprisesModel.php';

class EntreprisesController {
    private $model;
    private $pdo;

    public function __construct() {
        $this->pdo = Database::getConnection();
        $this->model = new EntreprisesModel($this->pdo);
    }

    // Afficher les entreprises avec pagination
    public function index() {
        $entreprisesParPage = 10; // Nombre d'entreprises par page
        $totalPages = $this->model->getTotalPages($entreprisesParPage); // Calcul des pages

        $pageActuelle = 1;
        if (isset($_GET["page"])) {
            if (!ctype_digit($_GET["page"]) || (int)$_GET["page"] < 1) {
                die("Erreur : Numéro de page invalide.");
            }
            $pageActuelle = min((int)$_GET["page"], $totalPages);
        }

        // Récupérer les entreprises pour la page actuelle
        $entreprisesAffichees = $this->model->getEntreprises($pageActuelle, $entreprisesParPage);

        if (empty($entreprisesAffichees)) {
            echo "<p style='color: red;'>⚠️ Erreur : Aucun résultat trouvé.</p>";
        }

        require 'src/views/entreprises.php'; // Passer les données à la vue
    }

    // Afficher le formulaire de création d'entreprise
    public function create() {
        require 'src/views/dashboard/entreprises/ajout-entreprise.php';
    }

    // Enregistrer une nouvelle entreprise
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Récupérer les données du formulaire
            $nom_entreprise = $_POST['nom_entreprise'] ?? '';
            $id_secteur = $_POST['id_secteur'] ?? '';
            $id_fichier = $_POST['id_fichier'] ?? '';
            $is_visible = isset($_POST['is_visible']) ? 1 : 0;


            // Appeler la méthode du modèle pour créer l'entreprise
            $this->model->create($nom_entreprise, $id_secteur, $id_fichier, $is_visible);

            // Rediriger vers la page principale des entreprises
            header("Location: index.php?action=index");
            exit;
        }
    }

    // Afficher le formulaire de modification d'une entreprise
    public function edit($id) {
        // Récupérer l'entreprise à modifier
        $entreprise = $this->model->getById($id);

        if (!$entreprise) {
            die("Entreprise non trouvée.");
        }

        require 'src/views/dashboard/entreprises/modif-entreprise.php'; // Passer l'entreprise à la vue
    }

    // Mettre à jour les informations d'une entreprise
    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Récupérer les données du formulaire
            $nom_entreprise = $_POST['nom_entreprise'] ?? '';
            $id_secteur = $_POST['id_secteur'] ?? '';
            $id_fichier = $_POST['id_fichier'] ?? '';
            $is_visible = isset($_POST['is_visible']) ? 1 : 0;

            // Appeler la méthode du modèle pour mettre à jour l'entreprise
            $this->model->update($id, $nom_entreprise, $id_secteur, $id_fichier, $is_visible);

            // Rediriger vers la page principale des entreprises
            header("Location: index.php?action=index");
            exit;
        }
    }

    // Supprimer une entreprise
    public function delete($id) {
        // Appeler la méthode du modèle pour supprimer l'entreprise
        $this->model->delete($id);

        // Rediriger vers la page principale des entreprises
        header("Location: index.php?action=index");
        exit;
    }
}
