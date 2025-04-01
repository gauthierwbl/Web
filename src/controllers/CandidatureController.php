<?php

require_once 'src/models/Database.php';
require_once 'src/models/CandidatureModel.php';

class CandidatureController {
    private $model;

    public function __construct() {
        $pdo = Database::getConnection();
        $this->model = new CandidatureModel($pdo);
    }
}
?>