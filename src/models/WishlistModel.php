<?php

/**
 * Classe WishlistModel
 * Gère les interactions avec la base de données pour les fonctionnalités de wishlist
 */
class WishlistModel {
    private $pdo;

    /**
     * Constructeur
     * @param PDO $pdo Connexion à la base de données
     */
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    /**
     * Récupère les offres dans la wishlist d'un utilisateur
     * @param int $userId ID de l'utilisateur
     * @param int $page Numéro de la page
     * @param int $limit Nombre d'éléments par page
     * @return array Liste des offres
     */
    public function getWishlistByUser($userId, $page = 1, $limit = 10) {
        $offset = ($page - 1) * $limit;

        // Requête modifiée pour inclure la note moyenne
        $query = "
            SELECT o.*, e.nom_entreprise, COALESCE(AVG(n.note), 0) AS moyenne_note
            FROM ajouter_wishlist w
            JOIN offres o ON w.id_offre = o.id_offre
            JOIN entreprises e ON o.id_entreprise = e.id_entreprise
            LEFT JOIN notes n ON e.id_entreprise = n.id_entreprise
            WHERE w.id_utilisateurs = :userId
            GROUP BY o.id_offre
            LIMIT :limit OFFSET :offset
        ";

        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue(':userId', $userId, PDO::PARAM_INT);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Calcule le nombre total de pages
     * @param int $userId ID de l'utilisateur
     * @param int $limit Nombre d'éléments par page
     * @return int Nombre total de pages
     */
    public function getTotalPages($userId, $limit = 10) {
        $query = "
            SELECT COUNT(*) 
            FROM ajouter_wishlist 
            WHERE id_utilisateurs = :userId
        ";

        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->execute();
        $total = $stmt->fetchColumn();

        return ceil($total / $limit);
    }

    /**
     * Vérifie si une offre est dans la wishlist
     * @param int $userId ID de l'utilisateur
     * @param int $offreId ID de l'offre
     * @return bool True si l'offre est dans la wishlist, false sinon
     */
    public function isInWishlist($userId, $offreId) {
        $query = "
            SELECT COUNT(*) 
            FROM ajouter_wishlist 
            WHERE id_utilisateurs = :userId 
            AND id_offre = :offreId
        ";

        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->bindParam(':offreId', $offreId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchColumn() > 0;
    }

    /**
     * Ajoute une offre à la wishlist
     * @param int $userId ID de l'utilisateur
     * @param int $offreId ID de l'offre
     * @return bool Résultat de l'opération
     */
    public function addToWishlist($userId, $offreId) {
        // Requête simplifiée sans date_ajout
        $query = "
            INSERT IGNORE INTO ajouter_wishlist 
            (id_utilisateurs, id_offre) 
            VALUES (:userId, :offreId)
        ";

        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->bindParam(':offreId', $offreId, PDO::PARAM_INT);

        return $stmt->execute();
    }

    /**
     * Supprime une offre de la wishlist
     * @param int $userId ID de l'utilisateur
     * @param int $offreId ID de l'offre
     * @return bool Résultat de l'opération
     */
    public function removeFromWishlist($userId, $offreId) {
        $query = "
            DELETE FROM ajouter_wishlist 
            WHERE id_utilisateurs = :userId 
            AND id_offre = :offreId
        ";

        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->bindParam(':offreId', $offreId, PDO::PARAM_INT);

        return $stmt->execute();
    }

    /**
     * Vide la wishlist d'un utilisateur
     * @param int $userId ID de l'utilisateur
     * @return bool Résultat de l'opération
     */
    public function clearWishlist($userId) {
        $query = "
            DELETE FROM ajouter_wishlist 
            WHERE id_utilisateurs = :userId
        ";

        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);

        return $stmt->execute();
    }

    /**
     * Compte le nombre d'offres dans la wishlist d'un utilisateur
     * @param int $userId ID de l'utilisateur
     * @return int Nombre d'offres
     */
    public function countWishlistItems($userId) {
        $query = "
            SELECT COUNT(*) 
            FROM ajouter_wishlist 
            WHERE id_utilisateurs = :userId
        ";

        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchColumn();
    }
}
?>