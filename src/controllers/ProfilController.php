<?php

require_once 'src/models/ProfilModel.php';

class ProfilController {
    private $model;
    private $pdo;

    public function __construct() {
        // Connexion à la base de données
        $this->pdo = Database::getConnection();
        $this->model = new ProfilModel($this->pdo);
    }

    public function index($userId) {
        // Vérifier si le formulaire a été soumis
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Si une photo a été téléchargée
            if (isset($_FILES['fileToUpload']) && $_FILES['fileToUpload']['error'] === UPLOAD_ERR_OK) {
                // Traiter l'upload de la photo
                $this->handlePhotoUpload($userId);
            }

            // Si des informations du profil ont été mises à jour
            if (isset($_POST['update_profile']) && $_POST['update_profile'] === '1') {
                // Traiter la mise à jour des informations
                $this->handleProfileUpdate($userId);
            }
        }

        // Récupérer les informations du profil utilisateur
        $profil = $this->model->getProfilById($userId);

        // Récupérer les informations supplémentaires de l'utilisateur
        $identiteData = $this->model->getIdentiteByUserId($userId);
        $adresseData = $this->model->getAdresseByUserId($userId);
        $campusData = $this->model->getCampusInfoByUserId($userId);

        // Récupérer les statistiques de l'utilisateur
        $wishlistCount = $this->model->getWishlistCount($userId);
        $completedInternshipsCount = $this->model->getCompletedInternshipsCount($userId);
        $applicationsCount = $this->model->getApplicationsCount($userId);

        // Récupérer le chemin de la photo de profil
        $profilePhoto = $this->model->getProfilePhoto($userId);

        // Récupérer le login de l'utilisateur
        $login = $profil['login'];

        // Inclure la vue et passer les données
        require_once 'src/views/profil.php';
    }

    /**
     * Traite l'upload de la photo de profil
     */
    private function handlePhotoUpload($userId) {
        // Vérifier si le fichier est une image
        $check = getimagesize($_FILES['fileToUpload']['tmp_name']);
        if ($check !== false) {
            // C'est une image, on peut procéder
            $targetDirectory = 'src/Views/img/';
            $targetFile = $targetDirectory . 'id' . $userId . 'profil.png';

            // Tenter de déplacer le fichier
            if (move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $targetFile)) {
                // Succès, rediriger pour éviter la résoumission
                header('Location: index.php?module=profil&action=index&id=' . $userId);
                exit;
            } else {
                // Échec de l'upload
                $_SESSION['error'] = "Erreur lors du téléchargement de votre photo.";
            }
        } else {
            // Ce n'est pas une image
            $_SESSION['error'] = "Le fichier n'est pas une image valide.";
        }
    }

    /**
     * Traite la mise à jour des informations du profil
     */
    private function handleProfileUpdate($userId) {
        // Récupérer les données du formulaire
        $updateData = [
            // Informations utilisateur
            'login' => isset($_POST['login']) ? trim($_POST['login']) : null,

            // Informations d'identité
            'prenom' => isset($_POST['prenom']) ? trim($_POST['prenom']) : null,
            'nom' => isset($_POST['nom']) ? trim($_POST['nom']) : null,

            // Informations d'adresse
            'adresse' => isset($_POST['adresse']) ? trim($_POST['adresse']) : null,
            'zipcode' => isset($_POST['zipcode']) ? trim($_POST['zipcode']) : null,
            'ville' => isset($_POST['ville']) ? trim($_POST['ville']) : null,
        ];

        // Filtrer les valeurs vides ou null
        $updateData = array_filter($updateData, function($value) {
            return $value !== null && $value !== '';
        });

        // Si nous avons des données à mettre à jour
        if (!empty($updateData)) {
            if ($this->model->updateProfil($userId, $updateData)) {
                $_SESSION['success'] = "Profil mis à jour avec succès.";
            } else {
                $_SESSION['error'] = "Erreur lors de la mise à jour du profil.";
            }
        }

        // Rediriger pour éviter la résoumission
        header('Location: index.php?module=profil&action=index&id=' . $userId);
        exit;
    }
}