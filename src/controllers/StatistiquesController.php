<?php
require_once 'src/models/Database.php';
require_once 'src/models/StatistiquesModel.php';

class StatistiquesController {
    private $model;

    public function __construct() {
        $pdo = Database::getConnection();
        $this->model = new StatistiquesModel($pdo);
    }

    public function index() {
        // Récupération des données complètes
        $allEntreprises = $this->model->getStagesParEntreprise();
        $allDurees = $this->model->getStagesParDuree();
        $allWishlist = $this->model->getTopWishlist();

        // Mélange aléatoire et découpe à 20 lignes max
        shuffle($allEntreprises);
        shuffle($allDurees);
        shuffle($allWishlist);

        $stagesParEntreprise = array_slice($allEntreprises, 0, 10);
        $stagesParDuree = array_slice($allDurees, 0, 10);
        $topWishlist = array_slice($allWishlist, 0, 10);

        // Vue
        require 'src/views/dashboard/statistiques.php';
    }
}
?>