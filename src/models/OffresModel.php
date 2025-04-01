<?php
class OffresModel {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function index_dashboard() {
        $offresParPage = 10; // Nombre d'offres par page
        $totalPages = $this->model->getTotalPages($offresParPage);
    
        $pageActuelle = 1;
        if (isset($_GET["page"])) {
            if (!ctype_digit($_GET["page"]) || (int)$_GET["page"] < 1) {
                die("Erreur : Numéro de page invalide.");
            }
            $pageActuelle = min((int)$_GET["page"], $totalPages);
        }
    
        $offresAffichees = $this->model->getOffres($pageActuelle, $offresParPage);
    
        if (empty($offresAffichees)) {
            echo "<p style='color: red;'>⚠️ Erreur : Aucune offre trouvée.</p>";
        }
    
        require 'src/views/dashboard/offres/gestion-offres.php';
    }    

    // Récupérer toutes les offres avec pagination
    public function getOffres($page, $offresParPage) {
        $offset = ($page - 1) * $offresParPage;
        $query = "SELECT o.*, e.nom_entreprise FROM offres o JOIN entreprises e ON o.id_entreprise = e.id_entreprise LIMIT :offset, :offresParPage";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->bindParam(':offresParPage', $offresParPage, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtenir le nombre total de pages pour la pagination
    public function getTotalPages($offresParPage) {
        $query = "SELECT COUNT(*) FROM offres";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        $totalOffres = $stmt->fetchColumn();
        return ceil($totalOffres / $offresParPage);
    }

    // Créer une nouvelle offre
    public function create($nom_offre, $description_offre, $id_mineure, $competences, $duree_stage, $base_remuneration, $date_offre, $nombre_place, $nombre_candidature, $id_entreprise) {
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
        $stmt->execute();
    }

    // Mettre à jour une offre
    public function update($id_offre, $nom_offre, $description_offre, $id_mineure, $competences, $duree_stage, $base_remuneration, $date_offre, $nombre_place, $nombre_candidature, $id_entreprise) {
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
        $stmt->execute();
    }

    // Supprimer une offre
    public function delete($id_offre) {
        $query = "DELETE FROM offres WHERE id_offre = :id_offre";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':id_offre', $id_offre);
        $stmt->execute();
    }

    // Obtenir une offre par son ID
    public function getOffreById($id_offre) {
        $query = "SELECT * FROM offres WHERE id_offre = :id_offre";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':id_offre', $id_offre);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>
