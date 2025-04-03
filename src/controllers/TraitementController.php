<?php
require_once 'src/models/Database.php';
require_once 'src/models/TraitementModel.php';

// Définition de la classe TraitementController
class TraitementController {
    // Propriété pour stocker une instance du modèle
    private $model;
    private $pdo;

    public function __construct() {
        $this->pdo = Database::getConnection();
        $this->model = new TraitementModel($this->pdo);
    }

    // Méthode index pour afficher le formulaire
    public function index() {
        $this->handleForm(); // Appelle handleForm pour traiter l'affichage et la soumission du formulaire
    }


    // Méthode pour gérer le traitement du formulaire
    public function handleForm() {
        // Vérifie si la requête est de type POST
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            // Tableau pour stocker les erreurs
            $errors = [];
    
            // Récupérer l'ID de l'offre
            if (!isset($_POST["id_offre"]) || empty($_POST["id_offre"])) {
                die;
            }
            $id_offre = $_POST['id_offre']; // ID de l'offre pour laquelle l'utilisateur postule
    
            // Vérifie si un fichier a été téléversé et gère l'upload du CV
            $cvMessage = $this->model->uploadCV($_FILES['cv'] ?? null);
            if ($cvMessage) {
                $errors[] = $cvMessage; // Ajout du message d'erreur au tableau
            } elseif ($cvMessage) {
                $successMessages[] = $cvMessage; // Message de succès
            }
    
    
            // Sauvegarde de la lettre de motivation
            if (!empty($_POST['lettre_motivation'])) {
                $lettreMotivation = htmlspecialchars($_POST['lettre_motivation']);
                if ($this->model->saveMotivationLetter($lettreMotivation, $id_offre)) {
                    echo "<p style='color: green;'>La lettre de motivation a été enregistrée avec succès.</p>";
                } else {
                    echo "<p style='color: red;'>Erreur lors de l'enregistrement de la lettre de motivation.</p>";
                }
            } else {
                echo "<p style='color: red;'>La lettre de motivation ne peut pas être vide.</p>";
            }
                 /*   $message[] = "La lettre de motivation a été enregistrée avec succès.";
                } else {
                    $errors[] = "Erreur lors de l'enregistrement de la lettre de motivation.";
                }
            } else {
                $errors[] = "La lettre de motivation ne peut pas être vide.";
            
                if (empty($errors) && isset($message)) {
                    echo "<p style='color: green;'>$message</p>";
                }
            }*/
    
            // Affichage des erreurs, s'il y en a
            if (!empty($errors)) {
                foreach ($errors as $error) {
                    echo "<p style='color: red;'>$error</p>"; // Affichage de chaque erreur en rouge
                }
            }
    
            // Appel au modèle pour enregistrer les candidatures avec l'id_offre correct
            if (empty($errors)) {
                $this->model->saveCandidature($id_offre, $_SESSION['id_utilisateur'], $_POST['lettre_motivation']);
            }
        }
        include 'src/views/traitement.php'; // Charge la vue
    }
    
    
}
