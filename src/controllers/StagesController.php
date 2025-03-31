<?php
require_once 'src/models/StagesModel.php';

class StagesController {
    private $model;

    public function __construct() {
        $this->pdo = Database::getConnection();
        $this->model = new StagesModel($this->pdo);
    }

    // Afficher les stages validés avec pagination
    public function index() {
        $stagesParPage = 10;  // Nombre de stages par page
        $pageActuelle = isset($_GET['page']) ? (int)$_GET['page'] : 1;

        $stagesAffiches = $this->model->getStagesValides($pageActuelle, $stagesParPage);
        $totalPages = $this->model->getTotalPages($stagesParPage);

        require 'src/views/stages.php';  // Afficher la vue
    }

    // Supprimer un stage
    public function delete() {
        if (isset($_GET['id'])) {
            $id_offre = $_GET['id'];
            $this->model->deleteStage($id_offre);
            header("Location: index.php?module=stages&action=index");  // Rediriger après suppression
        } else {
            echo "Erreur : Stage non trouvé.";
        }
    }
}
?>
