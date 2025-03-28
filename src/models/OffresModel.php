<?php
require_once 'Database.php'; // Assurez-vous d'avoir un fichier pour la connexion

class OffresModel {
    private PDO $db;

    public function __construct() {
        $this->db = Database::getConnection(); 
    }

    // Récupérer toutes les offres
    public function getAllOffres(): array {
        $sql = "SELECT * FROM offres";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Récupérer une offre par son ID
    public function getOffreById(int $id): ?array {
        $sql = "SELECT * FROM offres WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Ajouter une offre
    public function addOffre(Offres $offre): bool {
        $sql = "INSERT INTO offres (titre, description, entreprise, duree, localisation) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            $offre->getTitre(),
            $offre->getDescription(),
            $offre->getEntreprise(),
            $offre->getDuree(),
            $offre->getLocalisation()
        ]);
    }

    // Supprimer une offre
    public function deleteOffre(int $id): bool {
        $sql = "DELETE FROM offres WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$id]);
    }
}

?>
