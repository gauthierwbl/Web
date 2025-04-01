<?php

class EvaluationModel {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Récupérer toutes les evaluations avec pagination
    public function getEvaluation($id_entreprise, $page = 1, $evaluationParPage = 5) {
        $offset = ($page - 1) * $evaluationParPage;
        $stmt = $this->pdo->prepare("
            SELECT n.id_note, n.note, n.id_utilisateurs, e.id_entreprise
            FROM notes n
            JOIN entreprises e ON n.id_entreprise = e.id_entreprise
            WHERE e.id_entreprise = :id_entreprise
            LIMIT :limit OFFSET :offset
        ");
        $stmt->bindValue(':limit', $evaluationParPage, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }    

    // Récupérer le nombre total de pages pour la pagination
    public function getTotalPages($evaluationParPage = 5) {
        $stmt = $this->pdo->prepare("
            SELECT COUNT(*) FROM notes
        ");
        $stmt->execute();
        $totalStages = $stmt->fetchColumn();
        return ceil($totalStages / $evaluationParPage);
    }

    // Créer une nouvelle evaluation
    public function create($note, $id_utilisateur, $id_entreprise) {
        $stmt = $this->pdo->prepare("INSERT INTO notes (note, id_utilisateur, id_entreprise) VALUES (:note, :id_utilisateur, :id_entreprise)");
            return $stmt->execute([
                ':note' => (int)$note,
                ':id_utilisateur' => (int)$id_utilisateur,
                ':id_entreprise' => (int)$id_entreprise
            ]);
    }

    // Récupérer les évaluations d'un entreprise par son ID
    public function getByEntrepriseId($id_entreprise) {
        $id_entreprise = (int)$id_entreprise;
        
        $stmt = $this->pdo->prepare("
            SELECT * FROM notes WHERE id_entreprise = :id_entreprise
        ");
        $stmt->execute([':id_entreprise' => $id_entreprise]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Récupérer la note moyenne d'une entreprise
    public function getMoyenneEntreprise($id_entreprise) {
        $id_entreprise = (int)$id_entreprise;
        
        $stmt = $this->pdo->prepare("
            SELECT AVG(note) as moyenne FROM notes WHERE id_entreprise = :id_entreprise
        ");
        $stmt->execute([':id_entreprise' => $id_entreprise]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $result ? round($result['moyenne'], 1) : 0;
    }

    // Convertir une note sur 20 en nombre d'étoiles (1-5)
    public function etoiles($note) {
        if ($note >= 0 && $note <= 4) {
            return 1;
        } elseif ($note >= 5 && $note <= 8) {
            return 2;
        } elseif ($note >= 9 && $note <= 12) {
            return 3;
        } elseif ($note >= 13 && $note <= 16) {
            return 4;
        } elseif ($note >= 17 && $note <= 20) {
            return 5;
        } else {
            return 0;
        }
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
