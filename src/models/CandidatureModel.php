<?php

class CandidatureModel {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
}
?>