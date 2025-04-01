<?php

require_once 'src/models/Database.php';
require_once 'src/models/CandidatureModel.php';

class CandidatureController {
    private $model;

    public function __construct() {
        $pdo = Database::getConnection();
        $this->model = new CandidatureModel($pdo);
    }

    // Affichage classique
    public function index() {
        require 'src/views/dashboard/candidatures/gestion-candidatures.php'; 
    }
}
?>