<?php

require_once 'src/models/Database.php';
require_once 'src/models/PilotesModel.php';

class PilotesController {
    private $model;
    private $pdo;

    public function __construct() {
        $this->pdo = Database::getConnection();
        $this->model = new PilotesModel($this->pdo);
    }
    
    /**
     * Fonction pour charger une vue une seule fois
     */
    private function loadViewOnce($viewPath, $data = []) {
        // Extraire les données pour les rendre disponibles dans la vue
        extract($data);
        
        // Inclure la vue
        if (defined('PAGE_ALREADY_LOADED')) return;
        require $viewPath;
    }

    public function index_dashboard() {
        $parPage = 10;
        $pageActuelle = isset($_GET['page']) && ctype_digit($_GET['page']) && $_GET['page'] > 0 ? (int)$_GET['page'] : 1;

        $total = $this->model->countPilotes();
        $totalPages = ceil($total / $parPage);

        $pilotes = $this->model->getPilotesPaginated($pageActuelle, $parPage);

        $this->loadViewOnce('src/views/dashboard/pilotes/gestion-pilotes.php', [
            'pilotes' => $pilotes,
            'pageActuelle' => $pageActuelle,
            'totalPages' => $totalPages
        ]);
    }
    
    /**
     * Rechercher un pilote dans le dashboard
     */
    public function recherche_dashboard() {
        // Récupérer le terme de recherche
        $terme = isset($_GET['terme']) ? trim($_GET['terme']) : '';
        
        if (empty($terme)) {
            // Rediriger vers la liste complète si aucun terme n'est fourni
            header('Location: index.php?module=pilotes&action=index_dashboard');
            exit;
        }
        
        // Effectuer la recherche
        $pilotes = $this->model->rechercherPilotesDashboard($terme);
        
        // Pour éviter des erreurs dans la vue
        $pageActuelle = 1;
        $totalPages = 1; // La recherche ne pagine pas, donc on met 1
        
        // Charger la vue dashboard avec les résultats
        $this->loadViewOnce('src/views/dashboard/pilotes/gestion-pilotes.php', [
            'pilotes' => $pilotes,
            'pageActuelle' => $pageActuelle,
            'totalPages' => $totalPages,
            'terme' => $terme
        ]);
    }

    public function create() {
        $villes = $this->model->getVilles();
        require 'src/views/dashboard/pilotes/ajout-pilote.php';
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $login = $_POST['login'] ?? '';
            $mot_de_passe = $_POST['mot_de_passe'] ?? '';
            $adresse = $_POST['adresse'] ?? '';
            $id_ville = $_POST['id_ville'] ?? '';
            $nom = $_POST['nom'] ?? '';
            $prenom = $_POST['prenom'] ?? '';

            if ($login && $mot_de_passe && $adresse && $id_ville && $nom && $prenom) {
                $hash = password_hash($mot_de_passe, PASSWORD_DEFAULT);
                $this->model->create($login, $hash, $nom, $prenom, $adresse, $id_ville);
                header("Location: index.php?module=pilotes&action=index_dashboard");
                exit;
            } else {
                $erreur = "Tous les champs sont requis.";
                $villes = $this->model->getVilles();
                require 'src/views/dashboard/pilotes/ajout-pilote.php';
            }
        }
    }

    public function edit($id) {
        $pilote = $this->model->getById($id);
        $villes = $this->model->getVilles();

        if (!$pilote) {
            die("Pilote introuvable.");
        }

        require 'src/views/dashboard/pilotes/modif-pilote.php';
    }

    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id_utilisateur'] ?? null;
            $login = $_POST['login'] ?? '';
            $mot_de_passe = $_POST['mot_de_passe'] ?? '';
            $adresse = $_POST['adresse'] ?? '';
            $id_ville = $_POST['id_ville'] ?? '';
            $nom = $_POST['nom'] ?? '';
            $prenom = $_POST['prenom'] ?? '';

            if ($id && $login && $adresse && $id_ville && $nom && $prenom) {
                $hash = !empty($mot_de_passe) ? password_hash($mot_de_passe, PASSWORD_DEFAULT) : null;
                $this->model->update($id, $login, $hash, $nom, $prenom, $adresse, $id_ville);
                header("Location: index.php?module=pilotes&action=index_dashboard");
                exit;
            } else {
                echo "Tous les champs sont requis pour la modification.";
            }
        }
    }

    public function delete($id) {
        $this->model->delete($id);
        header("Location: index.php?module=pilotes&action=index_dashboard");
        exit;
    }
}