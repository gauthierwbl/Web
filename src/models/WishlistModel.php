<?php

class WishlistModel {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getWishlistByUser($userId, $page = 1, $limit = 10) {
        $offset = ($page - 1) * $limit;
        $stmt = $this->pdo->prepare("
            SELECT o.* 
            FROM ajouter_wishlist w
            JOIN offres o ON w.id_offre = o.id_offre
            WHERE w.id_utilisateurs = :userId
            LIMIT :limit OFFSET :offset
        ");
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTotalPages($userId, $limit = 10) {
        $stmt = $this->pdo->prepare("
            SELECT COUNT(*) 
            FROM ajouter_wishlist 
            WHERE id_utilisateurs = :userId
        ");
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->execute();
        $total = $stmt->fetchColumn();
        return ceil($total / $limit);
    }

    public function addToWishlist($userId, $id_offre) {
        $stmt = $this->pdo->prepare("
            INSERT IGNORE INTO ajouter_wishlist (id_utilisateurs, id_offre) 
            VALUES (:userId, :id_offre)
        ");
        $stmt->execute([
            ':userId' => $userId,
            ':id_offre' => $id_offre
        ]);
    }

    public function removeFromWishlist($userId, $id_offre) {
        $stmt = $this->pdo->prepare("
            DELETE FROM ajouter_wishlist 
            WHERE id_utilisateurs = :userId AND id_offre = :id_offre
        ");
        $stmt->execute([
            ':userId' => $userId,
            ':id_offre' => $id_offre
        ]);
    }

    public function isInWishlist($userId, $id_offre) {
        $stmt = $this->pdo->prepare("
            SELECT COUNT(*) 
            FROM ajouter_wishlist 
            WHERE id_utilisateurs = :userId AND id_offre = :id_offre
        ");
        $stmt->execute([
            ':userId' => $userId,
            ':id_offre' => $id_offre
        ]);
        return $stmt->fetchColumn() > 0;
    }
}
?>