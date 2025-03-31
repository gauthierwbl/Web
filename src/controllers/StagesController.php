<?php
require_once 'src/models/Database.php';
require_once 'src/models/StagesModel.php';

class StagesController {
    //private $model;
    private $pdo;

    public function __construct() {
        $this->pdo = Database::getConnection();
        $this->model = new StagesModel($this->pdo);
    }


    public function afficherStages() {
        $stages = $this->model->getStages();

        if (empty($stages)) {
            echo "<p>Aucun stage trouvé.</p>";
        } else {
            foreach ($stages as $stage) {
                echo "<p>Stage ID: " . htmlspecialchars($stage['id_offre']) . "</p>";
            }
        }
    }


  /*  // Afficher les stages validés avec pagination
    public function index() {
        $stageParPage = 10; // Nombre de stage par page
        $totalPages = $this->model->getTotalPages($stageParPage); // Calcul des pages

        $pageActuelle = 1;
        if (isset($_GET["page"])) {
            if (!ctype_digit($_GET["page"]) || (int)$_GET["page"] < 1) {
                die("Erreur : Numéro de page invalide.");
            }
            $pageActuelle = min((int)$_GET["page"], $totalPages);
        }

        // Récupérer les stages valides pour la page actuelle
        $stages = $this->model->getStages($pageActuelle, $stageParPage);

        // Affichage pour débogage
        var_dump($stageAffichees);

        if (empty($stages)) {
            echo "<p style='color: red;'>⚠️ Erreur : Aucun résultat trouvé.</p>";
        }

        $pageActuelle = isset($pageActuelle) ? $pageActuelle : 1;
        $totalPages = isset($totalPages) ? $totalPages : 1;

        var_dump($pageActuelle, $totalPages);
        die();

        include 'views/MesStages.php'; // Passer les données à la vue
    }*/

        // Afficher tous les stages validés
        public function index() {
            // Récupérer les stages validés
            $stages = $this->model->getStages(); 
        
            // Vérification pour le débogage
            var_dump($stages); die(); // Vérifie si la variable contient des données
        
            require 'src/views/MesStages.php'; // Inclure la vue pour afficher les résultats
        }
        

    // Afficher le formulaire de création de stages
    public function create() {
        require 'src/views/MesStages.php';
    }
/*
    // Afficher un formulaire pour modifier un stage
    public function edit($id) {
        $stage = $this->model->getById($id);
        if (!$stage) {
            die("Stage non trouvé.");
        }
        require 'views/edit_stage.php';
    }

    // Mettre à jour un stage
    public function edit1($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_utilisateur = $_POST['id_utilisateur'] ?? '';
            $lettre_motivation = $_POST['lettre_motivation'] ?? '';
            $id_fichier = $_POST['id_fichier'] ?? '';

            // Appeler la méthode du modèle pour mettre à jour le stage
            $this->model->update($id, $id_utilisateur, $lettre_motivation, $id_fichier);
            
            // Rediriger vers la page principale des stages
            header("Location: index.php?action=index");
            exit;
        }
    }
*/
    // Supprimer un stage
    public function delete($id) {
        $this->model->delete($id);
        header("Location: index.php?action=index");
        exit;
    }
}
?>