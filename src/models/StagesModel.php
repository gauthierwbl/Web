<?php
require_once 'src/models/Database.php';

class StagesModel {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getStages() {
        $stmt = $this->pdo->prepare("SELECT * FROM candidater WHERE id_status = 3 LIMIT :limit OFFSET :offset");
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
/*
    // Récupérer tous les stages avec pagination
    public function getStages($page = 1, $limit = 10) {
        $offset = ($page - 1) * $limit;
        $stmt = $this->pdo->prepare("SELECT * FROM candidater WHERE id_status = 3");
        //$stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        //$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    

    // Récupérer le nombre total de pages pour la pagination
    public function getTotalPages($limit = 10) {
        $stmt = $this->pdo->query("SELECT COUNT(*) FROM candidater");
        $count = $stmt->fetchColumn();
        return ceil($count / $limit);
    }
*/
    // Créer un nouveau stage
    public function create($offre, $status, $utilisateur) {
        $stmt = $this->pdo->prepare("INSERT INTO candidater (offre, status, utilisateur) VALUES (:offre, :status, :utilisateur)");
        $stmt->execute([
            ':offre' => $this->validateInput($offre),
            ':status' => $this->validateInput($status),
            ':utilisateur' => $this->validateInput($utilisateur),
        ]);
    }

    // Récupérer un stage par son ID
    public function getById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM candidater WHERE id_offre = :id AND id_status = 3");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
/*
    // Modifier un stage
    public function edit($id, $id_utilisateur, $lettre_motivation, $id_fichier) {
        $stmt = $this->pdo->prepare("UPDATE candidater SET id_utilisateur = :utilisateur, lettre_motivation = :lettre, id_fichier = :fichier WHERE id_offre = :id AND id_status = 3");
        $stmt->execute([
            ':utilisateur' => $id_utilisateur,
            ':lettre' => htmlspecialchars($lettre_motivation, ENT_QUOTES, 'UTF-8'),
            ':fichier' => $id_fichier,
            ':id' => $id
        ]);
    }
*/
    // Supprimer un stage
    public function delete($id) {
        $stmt = $this->pdo->prepare("DELETE FROM candidater WHERE id_offre = :id AND id_status = 3");
        $stmt->execute([':id' => $id]);
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
