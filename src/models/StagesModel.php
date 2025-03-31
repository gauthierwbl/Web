<?php

class StagesModel {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Récupérer tous les stages validés avec pagination
    public function getStagesValides($page = 1, $stagesParPage = 10) {
        $offset = ($page - 1) * $stagesParPage;
        $stmt = $this->pdo->prepare("
            SELECT o.id_offre, o.nom_offre, e.nom_entreprise, c.id_status
            FROM offres o
            JOIN candidater c ON o.id_offre = c.id_offre
            JOIN entreprises e ON o.id_entreprise = e.id_entreprise
            JOIN statuts s ON c.id_status = s.id_status
            WHERE s.type_status = 'validé'
            LIMIT :limit OFFSET :offset
        ");
        $stmt->bindValue(':limit', $stagesParPage, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }    

    // Récupérer le nombre total de pages pour les stages validés
    public function getTotalPages($stagesParPage = 10) {
        $stmt = $this->pdo->prepare("
            SELECT COUNT(*) 
            FROM offres o
            JOIN candidater c ON o.id_offre = c.id_offre
            JOIN statuts s ON c.id_status = s.id_status
            WHERE s.type_status = 'validé'
        ");
        $stmt->execute();
        $totalStages = $stmt->fetchColumn();
        return ceil($totalStages / $stagesParPage);
    }    

    // Supprimer un stage
    public function deleteStage($id_offre) {
        // Supprimer l'entrée de candidater
        $stmt = $this->pdo->prepare("DELETE FROM candidater WHERE id_offre = :id_offre");
        $stmt->bindValue(':id_offre', $id_offre, PDO::PARAM_INT);
        $stmt->execute();

        // Optionnel : Supprimer l'offre de la table offres si nécessaire
        // $stmt = $this->pdo->prepare("DELETE FROM offres WHERE id_offre = :id_offre");
        // $stmt->bindValue(':id_offre', $id_offre, PDO::PARAM_INT);
        // $stmt->execute();
    }

    // Validation et nettoyage des entrées
    public function validateInput($input) {
        $pattern = "/^[a-zA-Z0-9\s\p{L}-]+$/u"; // Permet les lettres, chiffres et espaces, y compris les caractères spéciaux comme accents
        $input = trim($input); // Nettoyer les espaces superflus
        if (!preg_match($pattern, $input)) {
            die("Erreur : Données invalides détectées.");
        }
        return htmlspecialchars($input, ENT_QUOTES, 'UTF-8'); // Protection contre les injections XSS
    }
}
?>
