<?php

class EntreprisesModel {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Récupère toutes les entreprises
    public function getEntreprises_dashboard($page = 1, $limit = 10) {
        $offset = ($page - 1) * $limit;
        $stmt = $this->pdo->prepare("SELECT * FROM entreprises LIMIT :limit OFFSET :offset");
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Récupérer toutes les entreprises avec pagination
    public function getEntreprises($page = 1, $limit = 10) {
        $offset = ($page - 1) * $limit;
        $stmt = $this->pdo->prepare("SELECT * FROM entreprises WHERE is_visible = 1 LIMIT :limit OFFSET :offset");
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
            ':nom_entreprise' => $nom_entreprise,
            ':id_secteur' => (int)$id_secteur,
            ':id_fichier' => (int)$id_fichier,
            ':is_visible' => (int)$is_visible
        ]);
    }

    // Récupérer une entreprise par son ID
    public function getById($id_entreprise) {
        $id_entreprise = (int)$id_entreprise;

        $stmt = $this->pdo->prepare("SELECT * FROM entreprises WHERE id_entreprise = :id_entreprise");
        $stmt->execute([':id_entreprise' => $id_entreprise]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Mettre à jour une entreprise
    public function update($id_entreprise, $nom_entreprise, $id_secteur, $id_fichier, $is_visible) {
        $stmt = $this->pdo->prepare("UPDATE entreprises SET nom_entreprise = :nom_entreprise, id_secteur = :id_secteur, id_fichier = :id_fichier, is_visible = :is_visible WHERE id_entreprise = :id_entreprise");
        return $stmt->execute([
            ':id_entreprise' => (int)$id_entreprise,
            ':nom_entreprise' => $nom_entreprise,
            ':id_secteur' => (int)$id_secteur,
            ':id_fichier' => (int)$id_fichier,
            ':is_visible' => (int)$is_visible
        ]);
    }

    // Supprimer une entreprise
    public function delete($id_entreprise) {
        $stmt = $this->pdo->prepare("DELETE FROM entreprises WHERE id_entreprise = :id_entreprise");
        $stmt->execute([':id_entreprise' => $id_entreprise]);
    }

    public function setVisibility($id, $is_visible) {
        $stmt = $this->pdo->prepare("UPDATE entreprises SET is_visible = :is_visible WHERE id_entreprise = :id");
        $stmt->execute([
            ':is_visible' => $is_visible,
            ':id' => $id
        ]);
    }

    public function getEntreprisesAvecNotes($page = 1, $limit = 10) {
        // Calcul de l'offset pour la pagination
        $offset = ($page - 1) * $limit;

        // Préparer la requête SQL avec pagination et jointure
        $stmt = $this->pdo->prepare("
        SELECT e.*, 
               COALESCE(AVG(n.note), 0) AS moyenne_note
        FROM entreprises e
        LEFT JOIN notes n ON e.id_entreprise = n.id_entreprise
        GROUP BY e.id_entreprise
        LIMIT :limit OFFSET :offset
    ");

        // Lier les paramètres :limit et :offset
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);

        // Exécuter la requête
        $stmt->execute();

        // Retourner les résultats sous forme de tableau associatif
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Récupérer tous les secteurs d'activité
    public function getSecteursActivite() {
    try {
        $stmt = $this->pdo->query("SELECT id_secteur, nom_secteur FROM secteur_activites");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Erreur dans getSecteursActivite : " . $e->getMessage());
        return [];
    }
}

public function getOffresByEntreprise($id_entreprise) {
    // Récupérer les offres liées à cette entreprise
    $stmt = $this->pdo->prepare("SELECT * FROM offres WHERE id_entreprise = :id_entreprise");
    $stmt->bindParam(':id_entreprise', $id_entreprise, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

}