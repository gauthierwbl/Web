<?php
// Définition de la classe TraitementModel
class TraitementModel {
    private $pdo;

    // Constructeur pour établir la connexion à la base de données
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    
    // Méthode pour enregistrer la lettre de motivation
    public function saveMotivationLetter($lettre, $id_offre) {
        try {
            // Ajout de l'ID de l'offre dans l'insertion de la lettre de motivation
            $sql = "INSERT INTO candidater (lettre_motivation, id_offre) VALUES (:lettre_motivation, :id_offre)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(":lettre_motivation", $lettre, PDO::PARAM_STR);
            $stmt->bindParam(":id_offre", $id_offre, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            die("Erreur lors de l'enregistrement de la lettre de motivation : " . $e->getMessage());
        }
    }
    

    // Méthode pour gérer le téléchargement du CV
    public function uploadCV($file) {
        // Taille maximale du fichier (2 Mo)
        $maxFileSize = 2 * 1024 * 1024; // 2 Mo
        // Extensions de fichiers autorisées
        $allowedExtensions = ['pdf'];
        // Types MIME autorisés
        $allowedMimeTypes = [
            'application/pdf',
        ];

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Vérifier si un fichier a été téléversé
            if (!isset($_FILES["file"]) || $_FILES["file"]["error"] !== UPLOAD_ERR_OK) {
                die("Erreur : Aucun fichier n'a été téléversé ou une erreur est survenue.");
            }
        
            $file = $_FILES["file"];
            $uploadDir = "uploads/";
            $maxSize = 2 * 1024 * 1024; // 2 Mo
            $allowedMimeType = "application/pdf";
        
            // Vérifier et créer le dossier uploads si nécessaire
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
        
            // Vérifier la taille du fichier
            if ($file["size"] > $maxSize) {
                die("Erreur : Le fichier dépasse la taille maximale autorisée (2 Mo).");
            }
        
            // Vérifier le type MIME avec fileinfo
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $fileMimeType = finfo_file($finfo, $file["tmp_name"]);
            finfo_close($finfo);
        
            if ($fileMimeType !== $allowedMimeType) {
                die("Erreur : Seuls les fichiers PDF sont autorisés.");
            }
        
            // Assurer un nom de fichier unique avec la bonne extension
            $fileName = uniqid("file_", true) . ".pdf";
            $destination = $uploadDir . $fileName;
        
            // Sécuriser l'affichage du nom du fichier
            $safeFileName = htmlspecialchars(basename($file["name"]), ENT_QUOTES, 'UTF-8');
        
            // Déplacer le fichier dans le répertoire final
            if (move_uploaded_file($file["tmp_name"], $destination)) {
                echo "Succès : Le fichier <strong>$safeFileName</strong> a été téléversé";
            } else {
                die("Erreur : Impossible de déplacer le fichier.");
            }
        } else {
            die("Accès interdit.");
        }
}

public function saveCandidature($id_offre, $id_utilisateur, $lettre_motivation) {
    try {
        // Prépare la requête SQL pour insérer la candidature
        $query = "INSERT INTO candidater (id_offre, id_utilisateurs, lettre_motivation, id_status) 
          VALUES (:id_offre, :id_utilisateurs, :lettre_motivation, :id_status)";
        
        $stmt = $this->pdo->prepare($query);
        
        // Bind les paramètres
        $stmt->bindParam(':id_offre', $id_offre, PDO::PARAM_INT);
        $stmt->bindParam(':id_utilisateurs', $id_utilisateur, PDO::PARAM_INT);
        $stmt->bindParam(':lettre_motivation', $lettre_motivation, PDO::PARAM_STR);
        
        // Définit le statut par défaut à 1 (en attente)
        $id_status = 1;
        $stmt->bindParam(':id_status', $id_status, PDO::PARAM_INT);
        
        // Exécute la requête
        return $stmt->execute();
    } catch (PDOException $e) {
        // Gérer les erreurs
        die("Erreur lors de l'enregistrement de la candidature : " . $e->getMessage());
    }
}
}