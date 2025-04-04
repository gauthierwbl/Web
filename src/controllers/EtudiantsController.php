<?php

require_once 'src/models/Database.php';
require_once 'src/models/EtudiantsModel.php';

class EtudiantsController {
    private $model;
    private $pdo;

    public function __construct() {
        $this->pdo = Database::getConnection();
        $this->model = new EtudiantsModel($this->pdo);
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

    // Liste paginée des étudiants
    public function index_dashboard() {
        $parPage = 10;
        $pageActuelle = isset($_GET['page']) && ctype_digit($_GET['page']) && $_GET['page'] > 0 ? (int)$_GET['page'] : 1;

        $totalEtudiants = $this->model->countEtudiants();
        $totalPages = ceil($totalEtudiants / $parPage);

        $etudiants = $this->model->getEtudiantsPaginated($pageActuelle, $parPage);

        $this->loadViewOnce('src/views/dashboard/etudiants/gestion-etudiants.php', [
            'etudiants' => $etudiants,
            'pageActuelle' => $pageActuelle,
            'totalPages' => $totalPages
        ]);
    }
    
    /**
     * Rechercher un étudiant dans le dashboard
     */
    public function recherche_dashboard() {
        // Récupérer le terme de recherche
        $terme = isset($_GET['terme']) ? trim($_GET['terme']) : '';
        
        if (empty($terme)) {
            // Rediriger vers la liste complète si aucun terme n'est fourni
            header('Location: index.php?module=etudiants&action=index_dashboard');
            exit;
        }
        
        // Effectuer la recherche
        $etudiants = $this->model->rechercherEtudiantsDashboard($terme);
        
        // Pour éviter des erreurs dans la vue
        $pageActuelle = 1;
        $totalPages = 1; // La recherche ne pagine pas, donc on met 1
        
        // Charger la vue dashboard avec les résultats
        $this->loadViewOnce('src/views/dashboard/etudiants/gestion-etudiants.php', [
            'etudiants' => $etudiants,
            'pageActuelle' => $pageActuelle,
            'totalPages' => $totalPages,
            'terme' => $terme
        ]);
    }

    // Affiche le formulaire d'ajout
    public function create() {
        $villes = $this->model->getVilles();
        require 'src/views/dashboard/etudiants/ajout-etudiants.php';
    }

    // Ajout d'un étudiant
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $login = $_POST['login'] ?? '';
            $mot_de_passe = $_POST['mot_de_passe'] ?? '';
            $nom = $_POST['nom'] ?? '';
            $prenom = $_POST['prenom'] ?? '';
            $adresse = $_POST['adresse'] ?? '';
            $id_ville = $_POST['id_ville'] ?? null;

            if ($login && $mot_de_passe && $nom && $prenom && $adresse && $id_ville) {
                $hash = password_hash($mot_de_passe, PASSWORD_DEFAULT);
                $this->model->create($login, $hash, $nom, $prenom, $adresse, $id_ville);
                header("Location: index.php?module=etudiants&action=index_dashboard");
                exit;
            } else {
                $erreur = "Tous les champs sont requis.";
                $villes = $this->model->getVilles();
                require 'src/views/dashboard/etudiants/ajout-etudiants.php';
            }
        }
    }

    // Affiche la page d'édition
    public function edit($id) {
        $etudiant = $this->model->getById($id);
        $villes = $this->model->getVilles();

        if (!$etudiant) {
            die("Étudiant introuvable.");
        }

        require 'src/views/dashboard/etudiants/modif-etudiants.php';
    }

    // Mise à jour des données
    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id_utilisateur'] ?? null;
            $login = $_POST['login'] ?? '';
            $mot_de_passe = $_POST['mot_de_passe'] ?? null;
            $nom = $_POST['nom'] ?? '';
            $prenom = $_POST['prenom'] ?? '';
            $adresse = $_POST['adresse'] ?? '';
            $id_ville = $_POST['id_ville'] ?? null;

            if ($id && $login && $nom && $prenom && $adresse && $id_ville) {
                $hash = !empty($mot_de_passe) ? password_hash($mot_de_passe, PASSWORD_DEFAULT) : null;
                $this->model->update($id, $login, $hash, $nom, $prenom, $adresse, $id_ville);
                header("Location: index.php?module=etudiants&action=index_dashboard");
                exit;
            } else {
                echo "Tous les champs sont requis pour la modification.";
            }
        }
    }

    // Suppression d'un étudiant
    public function delete($id) {
        $this->model->delete($id);
        header("Location: index.php?module=etudiants&action=index_dashboard");
        exit;
    }
}