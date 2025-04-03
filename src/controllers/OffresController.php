<?php
require_once 'src/models/Database.php';
require_once 'src/models/OffresModel.php';

class OffresController {
    private $model;
    private $pdo;

    public function __construct() {
        // Démarrer la session si ce n'est pas déjà fait
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        $this->pdo = Database::getConnection();
        $this->model = new OffresModel($this->pdo);
    }

    /**
     * Affiche les offres pour le tableau de bord d'administration
     */
    public function index_dashboard() {
        $offresParPage = 10; // Nombre d'offres par page
        $totalPages = $this->model->getTotalPages($offresParPage);

        $pageActuelle = 1;
        if (isset($_GET["page"])) {
            if (!ctype_digit($_GET["page"]) || (int)$_GET["page"] < 1) {
                die("Erreur : Numéro de page invalide.");
            }
            $pageActuelle = min((int)$_GET["page"], $totalPages);
        }

        $offresAffichees = $this->model->getOffresAvecNotes($pageActuelle, $offresParPage);

        if (empty($offresAffichees)) {
            $_SESSION['error'] = "Aucune offre trouvée.";
        }

        require 'src/views/dashboard/offres/gestion-offres.php';
    }

    /**
     * Affiche les offres avec pagination pour les utilisateurs
     */
    public function index() {
        $offresParPage = 4;
        $totalPages = $this->model->getTotalPages($offresParPage);

        $pageActuelle = 1;
        if (isset($_GET["page"])) {
            if (!ctype_digit($_GET["page"]) || (int)$_GET["page"] < 1) {
                die("Erreur : Numéro de page invalide.");
            }
            $pageActuelle = min((int)$_GET["page"], $totalPages);
        }

        // Utiliser la méthode qui inclut les notes moyennes
        $offresAffichees = $this->model->getOffresAvecNotes($pageActuelle, $offresParPage);

        // Vérifier si l'utilisateur est connecté pour obtenir la wishlist
        $userId = $_SESSION['id_utilisateur'] ?? null;
        $wishlistItems = [];

        if ($userId) {
            require_once 'src/models/WishlistModel.php';
            $wishlistModel = new WishlistModel($this->pdo);

            // Pour chaque offre, vérifier si elle est dans la wishlist
            foreach ($offresAffichees as $index => $offre) {
                $offresAffichees[$index]['in_wishlist'] = $wishlistModel->isInWishlist($userId, $offre['id_offre']);
            }
        }

        require 'src/views/offres.php';
    }

    /**
     * Affiche les détails d'une offre
     */
    public function details() {
        if (!isset($_GET['id'])) {
            header("Location: index.php?module=offres&action=index");
            exit;
        }

        $id_offre = $_GET['id'];

        // Récupérer les détails de l'offre
        $offre = $this->model->getOffreById($id_offre);

        if (!$offre) {
            $_SESSION['error'] = "Offre non trouvée.";
            header("Location: index.php?module=offres&action=index");
            exit;
        }

        // Récupérer les informations de l'entreprise
        $entreprise = $this->model->getEntrepriseForOffre($id_offre);

        // Récupérer les informations de la mineure
        $mineure = $this->model->getMineureForOffre($id_offre);

        // Vérifier si l'offre est dans la wishlist de l'utilisateur
        $isInWishlist = false;
        $userId = $_SESSION['id_utilisateur'] ?? null;

        if ($userId) {
            require_once 'src/models/WishlistModel.php';
            $wishlistModel = new WishlistModel($this->pdo);
            $isInWishlist = $wishlistModel->isInWishlist($userId, $id_offre);
        }

        // Charger la vue des détails de l'offre
        require 'src/views/détail-offre.php';
    }

    /**
     * Affiche le formulaire de création d'offre
     */
    public function create() {
        // Récupération des entreprises et mineures pour affichage dans les <select>
        $entreprises = $this->model->getAllEntreprises(); 
        $mineures = $this->model->getAllMineures();       
    
        require 'src/views/dashboard/offres/ajout-offre.php';
    }
    

    /**
     * Enregistre une nouvelle offre
     */
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
            if ($this->model->create($nom_offre, $description_offre, $id_mineure, $competences, $duree_stage, $base_remuneration, $date_offre, $nombre_place, $nombre_candidature, $id_entreprise)) {
                $_SESSION['success'] = "Offre créée avec succès.";
            } else {
                $_SESSION['error'] = "Erreur lors de la création de l'offre.";
            }

            // Redirection vers la liste des offres après création
            header("Location: index.php?module=offres&action=index_dashboard");
            exit();
        }
    }

    /**
     * Affiche le formulaire de modification d'offre
     */
    public function edit() {
        if (isset($_GET['id'])) {
            $id_offre = $_GET['id'];
            $offre = $this->model->getOffreById($id_offre);
    
            if (!$offre) {
                $_SESSION['error'] = "Offre non trouvée.";
                header("Location: index.php?module=offres&action=index_dashboard");
                exit;
            }
    
            // 🔥 On ajoute ça pour récupérer les options dynamiques
            $entreprises = $this->model->getAllEntreprises();
            $mineures = $this->model->getAllMineures();
    
            require 'src/views/dashboard/offres/modif-offre.php';
        } else {
            $_SESSION['error'] = "ID de l'offre non spécifié.";
            header("Location: index.php?module=offres&action=index_dashboard");
            exit;
        }
    }
    

    /**
     * Met à jour une offre
     */
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
            if ($this->model->update($id_offre, $nom_offre, $description_offre, $id_mineure, $competences, $duree_stage, $base_remuneration, $date_offre, $nombre_place, $nombre_candidature, $id_entreprise)) {
                $_SESSION['success'] = "Offre mise à jour avec succès.";
            } else {
                $_SESSION['error'] = "Erreur lors de la mise à jour de l'offre.";
            }

            // Redirection vers la liste des offres après modification
            header("Location: index.php?module=offres&action=index_dashboard");
            exit();
        }
    }

    /**
     * Supprime une offre
     */
    public function delete() {
        if (isset($_GET['id'])) {
            $id_offre = $_GET['id'];

            // Suppression de l'offre
            if ($this->model->delete($id_offre)) {
                $_SESSION['success'] = "Offre supprimée avec succès.";
            } else {
                $_SESSION['error'] = "Erreur lors de la suppression de l'offre.";
            }

            // Redirection vers la liste des offres après suppression
            header("Location: index.php?module=offres&action=index_dashboard");
            exit();
        } else {
            $_SESSION['error'] = "ID de l'offre non spécifié.";
            header("Location: index.php?module=offres&action=index_dashboard");
            exit;
        }
    }
}
?>