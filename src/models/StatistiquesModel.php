<?php

class StatistiquesModel {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Nombre de stages par entreprise
    public function getStagesParEntreprise() {
        $sql = "
            SELECT e.nom_entreprise, COUNT(o.id_offre) AS nb_stages
            FROM entreprises e
            LEFT JOIN offres o ON e.id_entreprise = o.id_entreprise
            GROUP BY e.nom_entreprise
        ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Nombre de stages par durée
    public function getStagesParDuree() {
        $sql = "
            SELECT duree_stage, COUNT(*) AS nb_stages
            FROM offres
            GROUP BY duree_stage
        ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }  

    // Top des offres les plus ajoutées à la wishlist
    public function getTopWishlist() {
        $sql = "
            SELECT o.nom_offre, COUNT(aw.id_offre) AS nb_wishlist
            FROM offres o
            JOIN ajouter_wishlist aw ON o.id_offre = aw.id_offre
            GROUP BY o.nom_offre
            ORDER BY nb_wishlist DESC
            LIMIT 5
        ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
