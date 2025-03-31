<?php
class WishlistModel {
    private $db;

    // Constructeur pour initialiser la connexion à la base de données
    public function __construct($db) {
        $this->db = $db;
    }

    // Ajouter une offre à la wishlist
    public function create($id_utilisateur, $id_offre) {
        // Vérifier si l'offre est déjà dans la wishlist de l'utilisateur
        $query = "SELECT * FROM wishlist WHERE id_utilisateur = :id_utilisateur AND id_offre = :id_offre";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id_utilisateur', $id_utilisateur);
        $stmt->bindParam(':id_offre', $id_offre);
        $stmt->execute();

        if ($stmt->rowCount() == 0) {
            // Ajouter l'offre à la wishlist si elle n'est pas déjà présente
            $query = "INSERT INTO wishlist (id_utilisateur, id_offre) VALUES (:id_utilisateur, :id_offre)";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':id_utilisateur', $id_utilisateur);
            $stmt->bindParam(':id_offre', $id_offre);
            $stmt->execute();
            return true;
        }
        return false;
    }

    // Récupérer toutes les offres de la wishlist pour un utilisateur
    public function show($id_utilisateur) {
        $query = "SELECT * FROM wishlist WHERE id_utilisateur = :id_utilisateur";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id_utilisateur', $id_utilisateur);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Supprimer une offre de la wishlist
    public function delete($id_utilisateur, $id_offre) {
        $query = "DELETE FROM wishlist WHERE id_utilisateur = :id_utilisateur AND id_offre = :id_offre";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id_utilisateur', $id_utilisateur);
        $stmt->bindParam(':id_offre', $id_offre);
        $stmt->execute();
        return true;
    }
}
?>
