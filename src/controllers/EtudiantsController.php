<?php

require_once 'src/models/Database.php';
require_once 'src/models/EtudiantsModel.php';

class EtudiantsController {
    private $model;

    public function __construct() {
        $pdo = Database::getConnection();
        $this->model = new EtudiantsModel($pdo);
    }

        
}
