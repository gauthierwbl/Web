<?php
require_once 'src/models/Database.php';
// Inclusion du modèle qui gère les opérations liées au traitement des formulaires
require_once 'src/models/TraitementModel.php';

// Définition de la classe TraitementController
class TraitementController {
    // Propriété pour stocker une instance du modèle
    private $model;

    // Constructeur de la classe
    public function __construct() {
        // Initialisation de l'objet modèle
        $this->model = new TraitementModel();
    }

    // Méthode pour gérer le traitement du formulaire
    public function handleForm() {
        // Vérifie si la requête est de type POST
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            // Tableau pour stocker les erreurs
            $errors = [];

            // Appel de la méthode pour uploader le CV et récupérer un message d'erreur éventuel
            $cvMessage = $this->model->uploadCV($_FILES['cv'] ?? null);
            if ($cvMessage) {
                $errors[] = $cvMessage; // Ajout du message d'erreur au tableau
            }

            // Affichage des erreurs, s'il y en a
            if (!empty($errors)) {
                foreach ($errors as $error) {
                    echo "<p style='color: red;'>$error</p>"; // Affichage de chaque erreur en rouge
                }
            }
        }
         // Inclusion de la vue pour afficher le traitement du formulaire
         include 'views/traitement.php';
    }
    
    
}
