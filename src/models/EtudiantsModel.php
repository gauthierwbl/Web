<?php

class EtudiantsModel {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Compter le nombre total d'étudiants
    public function countEtudiants() {
        $query = "SELECT COUNT(*) FROM utilisateurs WHERE id_role = 3"; // 3 = étudiant
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        return (int) $stmt->fetchColumn();
    }

    
}
