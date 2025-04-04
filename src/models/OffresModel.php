<?php
class OffresModel {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    /**
     * Récupère toutes les offres avec pagination
     */
    public function getOffres($page, $offresParPage) {
        $offset = ($page - 1) * $offresParPage;
        $query = "SELECT o.*, e.nom_entreprise FROM offres o JOIN entreprises e ON o.id_entreprise = e.id_entreprise LIMIT :offset, :offresParPage";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->bindParam(':offresParPage', $offresParPage, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Rechercher des offres dans le frontend
     */
    public function rechercherOffres($terme) {
        try {
            // Préparer la requête SQL
            $sql = "SELECT * FROM offres WHERE nom_offre LIKE :terme";
            $stmt = $this->pdo->prepare($sql);
            
            // Définir les paramètres
            $termeRecherche = "%" . $terme . "%";
            $stmt->bindParam(':terme', $termeRecherche, PDO::PARAM_STR);
            
            // Exécuter la requête
            $stmt->execute();
            
            // Retourner les résultats
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erreur lors de la recherche d'offres : " . $e->getMessage());
            return [];
        }
    }

    /**
     * Rechercher des offres dans le dashboard
     */
    public function rechercherOffresDashboard($terme) {
        try {
            // Préparer la requête SQL pour rechercher par nom d'offre ou entreprise
            $sql = "SELECT o.*, e.nom_entreprise, COALESCE(AVG(n.note), 0) AS moyenne_note
                   FROM offres o 
                   JOIN entreprises e ON o.id_entreprise = e.id_entreprise
                   LEFT JOIN notes n ON e.id_entreprise = n.id_entreprise
                   WHERE o.nom_offre LIKE :terme OR e.nom_entreprise LIKE :terme
                   GROUP BY o.id_offre";
            
            $stmt = $this->pdo->prepare($sql);
            
            // Définir le paramètre de recherche
            $termeRecherche = "%" . $terme . "%";
            $stmt->bindParam(':terme', $termeRecherche, PDO::PARAM_STR);
            
            // Exécuter la requête
            $stmt->execute();
            
            // Retourner les résultats
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erreur lors de la recherche d'offres dans le dashboard : " . $e->getMessage());
            return [];
        }
    }

    /**
     * Récupère toutes les offres avec notes et pagination
     */
    public function getOffresAvecNotes($page, $offresParPage) {
        $offset = ($page - 1) * $offresParPage;

        try {
            // Requête avec les notes moyennes des entreprises
            $query = "SELECT o.*, e.nom_entreprise, COALESCE(AVG(n.note), 0) AS moyenne_note
                     FROM offres o 
                     JOIN entreprises e ON o.id_entreprise = e.id_entreprise
                     LEFT JOIN notes n ON e.id_entreprise = n.id_entreprise
                     GROUP BY o.id_offre
                     LIMIT :offset, :offresParPage";

            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
            $stmt->bindParam(':offresParPage', $offresParPage, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erreur dans getOffresAvecNotes: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Obtenir le nombre total de pages pour la pagination
     */
    public function getTotalPages($offresParPage) {
        try {
            $query = "SELECT COUNT(*) FROM offres";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute();
            $totalOffres = $stmt->fetchColumn();
            return ceil($totalOffres / $offresParPage);
        } catch (PDOException $e) {
            error_log("Erreur dans getTotalPages: " . $e->getMessage());
            return 1;
        }
    }

    /**
     * Créer une nouvelle offre
     */
    public function create($nom_offre, $description_offre, $id_mineure, $competences, $duree_stage, $base_remuneration, $date_offre, $nombre_place, $nombre_candidature, $id_entreprise) {
        try {
            $query = "INSERT INTO offres (nom_offre, description_offre, id_mineure, competences, duree_stage, base_remuneration, date_offre, nombre_place, nombre_candidature, id_entreprise) 
                      VALUES (:nom_offre, :description_offre, :id_mineure, :competences, :duree_stage, :base_remuneration, :date_offre, :nombre_place, :nombre_candidature, :id_entreprise)";
            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(':nom_offre', $nom_offre);
            $stmt->bindParam(':description_offre', $description_offre);
            $stmt->bindParam(':id_mineure', $id_mineure);
            $stmt->bindParam(':competences', $competences);
            $stmt->bindParam(':duree_stage', $duree_stage);
            $stmt->bindParam(':base_remuneration', $base_remuneration);
            $stmt->bindParam(':date_offre', $date_offre);
            $stmt->bindParam(':nombre_place', $nombre_place);
            $stmt->bindParam(':nombre_candidature', $nombre_candidature);
            $stmt->bindParam(':id_entreprise', $id_entreprise);
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Erreur dans create: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Mettre à jour une offre
     */
    public function update($id_offre, $nom_offre, $description_offre, $id_mineure, $competences, $duree_stage, $base_remuneration, $date_offre, $nombre_place, $nombre_candidature, $id_entreprise) {
        try {
            $query = "UPDATE offres SET nom_offre = :nom_offre, description_offre = :description_offre, id_mineure = :id_mineure, competences = :competences, duree_stage = :duree_stage, 
                      base_remuneration = :base_remuneration, date_offre = :date_offre, nombre_place = :nombre_place, nombre_candidature = :nombre_candidature, id_entreprise = :id_entreprise 
                      WHERE id_offre = :id_offre";
            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(':id_offre', $id_offre);
            $stmt->bindParam(':nom_offre', $nom_offre);
            $stmt->bindParam(':description_offre', $description_offre);
            $stmt->bindParam(':id_mineure', $id_mineure);
            $stmt->bindParam(':competences', $competences);
            $stmt->bindParam(':duree_stage', $duree_stage);
            $stmt->bindParam(':base_remuneration', $base_remuneration);
            $stmt->bindParam(':date_offre', $date_offre);
            $stmt->bindParam(':nombre_place', $nombre_place);
            $stmt->bindParam(':nombre_candidature', $nombre_candidature);
            $stmt->bindParam(':id_entreprise', $id_entreprise);
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Erreur dans update: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Supprimer une offre
     */
    public function delete($id_offre) {
        try {
            $query = "DELETE FROM offres WHERE id_offre = :id_offre";
            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(':id_offre', $id_offre);
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Erreur dans delete: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Obtenir une offre par son ID
     */
    public function getOffreById($id_offre) {
        try {
            $query = "SELECT o.*, e.nom_entreprise, COALESCE(AVG(n.note), 0) AS moyenne_note
                      FROM offres o 
                      JOIN entreprises e ON o.id_entreprise = e.id_entreprise
                      LEFT JOIN notes n ON e.id_entreprise = n.id_entreprise
                      WHERE o.id_offre = :id_offre
                      GROUP BY o.id_offre";
            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(':id_offre', $id_offre);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erreur dans getOffreById: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Récupère l'entreprise d'une offre
     */
    public function getEntrepriseForOffre($id_offre) {
        try {
            $stmt = $this->pdo->prepare("
                SELECT e.* 
                FROM entreprises e
                JOIN offres o ON e.id_entreprise = o.id_entreprise
                WHERE o.id_offre = :id_offre
            ");
            $stmt->bindParam(':id_offre', $id_offre, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erreur dans getEntrepriseForOffre: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Récupère la mineure d'une offre
     */
    public function getMineureForOffre($id_offre) {
        try {
            $stmt = $this->pdo->prepare("
                SELECT m.* 
                FROM mineures m
                JOIN offres o ON m.id_mineure = o.id_mineure
                WHERE o.id_offre = :id_offre
            ");
            $stmt->bindParam(':id_offre', $id_offre, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erreur dans getMineureForOffre: " . $e->getMessage());
            return null;
        }
    }

    public function getAllEntreprises() {
        try {
            $stmt = $this->pdo->query("SELECT id_entreprise, nom_entreprise FROM entreprises");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erreur dans getAllEntreprises : " . $e->getMessage());
            return [];
        }
    }
    
    public function getAllMineures() {
        try {
            $stmt = $this->pdo->query("SELECT id_mineure, nom_mineure FROM mineures");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erreur dans getAllMineures : " . $e->getMessage());
            return [];
        }
    }
}
?>