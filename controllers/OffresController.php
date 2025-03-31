<?php
require_once 'models/Database.php';
require_once 'models/OffresModel.php';

class OffresController {
    private $model;
    private $pdo;

    public function __construct() {
        $this->pdo = Database::getConnection();
        $this->model = new OffresModel($this->pdo);
    }

    // Afficher les offres avec pagination
    public function index() {
        $offresParPage = 10;
        $totalPages = $this->model->getTotalPages($offresParPage);

        $pageActuelle = 1;
        if (isset($_GET["page"])) {
            if (!ctype_digit($_GET["page"]) || (int)$_GET["page"] < 1) {
                die("Erreur : Numéro de page invalide.");
            }
            $pageActuelle = min((int)$_GET["page"], $totalPages);
        }

        $offresAffichees = $this->model->getOffres($pageActuelle, $offresParPage);

        if (empty($offresAffichees)) {
            echo "<p style='color: red;'>⚠️ Erreur : Aucune offre trouvée.</p>";
        }

        require 'views/offres.php';
    }

    // Afficher le formulaire de création d'offre
    public function create() {
        require 'views/createoffre.php';
    }

    // Enregistrer une nouvelle offre
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nom_offre = $_POST['nom_offre'] ?? '';
            $description_offre = $_POST['description_offre'] ?? '';
            $id_mineure = $_POST['id_mineure'] ?? '';
            $competences = $_POST['competences'] ?? '';
            $duree_stage = $_POST['duree_stage'] ?? '';
            $base_remuneration = $_POST['base_remuneration'] ?? '';
            $date_offre = $_POST['date_offre'] ?? '';
            $nombre_place = $_POST['nombre_place'] ?? '';
            $nombre_candidature = $_POST['nombre_candidature'] ?? '';
            $id_entreprise = $_POST['id_entreprise'] ?? '';

            // Appel de la méthode pour créer l'offre
            $this->model->create($nom_offre, $description_offre, $id_mineure, $competences, $duree_stage, $base_remuneration, $date_offre, $nombre_place, $nombre_candidature, $id_entreprise);

            // Redirection vers la liste des offres après création
            header("Location: index.php?module=offres&action=index");
            exit();
        }
    }

    // Afficher le formulaire de modification d'offre
    public function edit() {
        if (isset($_GET['id'])) {
            $id_offre = $_GET['id'];
            $offre = $this->model->getOffreById($id_offre);
            require 'views/editoffre.php';
        } else {
            echo "Erreur : Offre non trouvée.";
        }
    }

    // Mettre à jour une offre
    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_offre = $_POST['id_offre'];
            $nom_offre = $_POST['nom_offre'] ?? '';
            $description_offre = $_POST['description_offre'] ?? '';
            $id_mineure = $_POST['id_mineure'] ?? '';
            $competences = $_POST['competences'] ?? '';
            $duree_stage = $_POST['duree_stage'] ?? '';
            $base_remuneration = $_POST['base_remuneration'] ?? '';
            $date_offre = $_POST['date_offre'] ?? '';
            $nombre_place = $_POST['nombre_place'] ?? '';
            $nombre_candidature = $_POST['nombre_candidature'] ?? '';
            $id_entreprise = $_POST['id_entreprise'] ?? '';

            // Mise à jour de l'offre
            $this->model->update($id_offre, $nom_offre, $description_offre, $id_mineure, $competences, $duree_stage, $base_remuneration, $date_offre, $nombre_place, $nombre_candidature, $id_entreprise);

            // Redirection vers la liste des offres après modification
            header("Location: index.php?module=offres&action=index");
            exit();
        }
    }

    // Supprimer une offre
    public function delete() {
        if (isset($_GET['id'])) {
            $id_offre = $_GET['id'];
            // Suppression de l'offre
            $this->model->delete($id_offre);

            // Redirection vers la liste des offres après suppression
            header("Location: index.php?module=offres&action=index");
            exit();
        } else {
            echo "Erreur : Offre non trouvée.";
        }
    }
}
?>
