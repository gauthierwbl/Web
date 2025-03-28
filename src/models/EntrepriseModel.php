<?php

class EntrepriseModel {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Récupérer toutes les entreprises avec pagination
    public function getEntreprises($page = 1, $limit = 10) {
        $offset = ($page - 1) * $limit;
        $stmt = $this->pdo->prepare("SELECT * FROM entreprises LIMIT :limit OFFSET :offset");
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Récupérer le nombre total de pages pour la pagination
    public function getTotalPages($limit = 10) {
        $stmt = $this->pdo->query("SELECT COUNT(*) FROM entreprises");
        $count = $stmt->fetchColumn();
        return ceil($count / $limit);
    }

    // Créer une nouvelle entreprise
    public function create($nom_entreprise, $id_secteur, $id_fichier = 50, $is_visible = 1) {
        $stmt = $this->pdo->prepare("INSERT INTO entreprises (nom_entreprise, id_secteur, id_fichier, is_visible) VALUES (:nom_entreprise, :id_secteur, :id_fichier, :is_visible)");
        return $stmt->execute([
            ':nom_entreprise' => $this->validateInput($nom_entreprise),
            ':id_secteur' => $id_secteur,
            ':id_fichier' => $id_fichier,
            ':is_visible' => $is_visible
        ]);
    }

    // Récupérer une entreprise par son ID
    public function getById($id_entreprise) {
        $stmt = $this->pdo->prepare("SELECT * FROM entreprises WHERE id_entreprise = :id_entreprise");
        $stmt->execute([':id_entreprise' => $id_entreprise]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Mettre à jour une entreprise
    public function update($id_entreprise, $nom_entreprise, $id_secteur, $id_fichier, $is_visible) {
        $stmt = $this->pdo->prepare("UPDATE entreprises SET nom_entreprise = :nom_entreprise, id_secteur = :id_secteur, id_fichier = :id_fichier, is_visible = :is_visible WHERE id_entreprise = :id_entreprise");
        return $stmt->execute([
            ':id_entreprise' => $id_entreprise,
            ':nom_entreprise' => $this->validateInput($nom_entreprise),
            ':id_secteur' => $id_secteur,
            ':id_fichier' => $id_fichier,
            ':is_visible' => $is_visible
        ]);
    }

    // Supprimer une entreprise
    public function delete($id_entreprise) {
        $stmt = $this->pdo->prepare("DELETE FROM entreprises WHERE id_entreprise = :id_entreprise");
        return $stmt->execute([':id_entreprise' => $id_entreprise]);
    }
}
