<?php

class CandidatureModel {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    /**
     * Récupère toutes les offres auxquelles un étudiant a postulé
     */
    public function getAllOffresCandidatees($id_utilisateur, $terme = '', $limit = 10, $offset = 0) {
        $query = "
            SELECT 
                o.id_offre,
                o.nom_offre,
                o.description_offre,
                o.competences,
                o.duree_stage,
                o.base_remuneration,
                o.date_offre,
                o.nombre_place,
                o.nombre_candidature,
                e.nom_entreprise,
                u.id_utilisateurs,  -- Seulement l'ID de l'utilisateur
                c.lettre_motivation,
                c.id_status
            FROM candidater c
            JOIN offres o ON c.id_offre = o.id_offre
            JOIN entreprises e ON o.id_entreprise = e.id_entreprise
            JOIN utilisateurs u ON c.id_utilisateurs = u.id_utilisateurs
            WHERE c.id_utilisateurs = :id_utilisateur
        ";

        // Ajouter la recherche par terme (si applicable)
        if ($terme) {
            $query .= " AND o.nom_offre LIKE :terme";
        }

        $query .= " LIMIT :limit OFFSET :offset";

        $stmt = $this->pdo->prepare($query);
        
        // Lier les paramètres
        $stmt->bindValue(':id_utilisateur', $id_utilisateur, PDO::PARAM_INT);
        if ($terme) {
            $stmt->bindValue(':terme', '%' . $terme . '%', PDO::PARAM_STR); // Recherche par nom de l'offre
        }
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Récupère le nombre total de candidatures pour un étudiant
     */
    public function getTotalPages($id_utilisateur, $limit = 10) {
        // Effectuer la requête pour compter le nombre total de candidatures
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM candidater WHERE id_utilisateurs = :id_utilisateur");
        $stmt->bindValue(':id_utilisateur', $id_utilisateur, PDO::PARAM_INT);
        $stmt->execute();
        $count = $stmt->fetchColumn();
        
        // Calculer le nombre total de pages
        return ceil($count / $limit);
    }

    /**
     * Récupérer une candidature spécifique par ID d'utilisateur et ID d'offre
     */
    public function getCandidatureById($id_utilisateur, $id_offre) {
        $stmt = $this->pdo->prepare("
            SELECT * FROM candidater
            WHERE id_utilisateurs = :id_utilisateurs AND id_offre = :id_offre
        ");
        $stmt->bindParam(':id_utilisateurs', $id_utilisateur, PDO::PARAM_INT);
        $stmt->bindParam(':id_offre', $id_offre, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Mettre à jour le statut de la candidature
     */
    public function updateCandidatureStatus($id_utilisateur, $id_offre, $id_status) {
        $stmt = $this->pdo->prepare("
            UPDATE candidater
            SET id_status = :id_status
            WHERE id_utilisateurs = :id_utilisateurs AND id_offre = :id_offre
        ");
        $stmt->bindParam(':id_status', $id_status, PDO::PARAM_INT);
        $stmt->bindParam(':id_utilisateurs', $id_utilisateur, PDO::PARAM_INT);
        $stmt->bindParam(':id_offre', $id_offre, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
?>
