<?php

require_once(__DIR__ . '/../models/ProfilModel.php');



class ProfilController {
    private $profilModel;

    public function __construct($database) {
        $this->profilModel = new ProfilModel($database);
    }

    /**
     * Affiche la page de profil de l'utilisateur
     */
    public function afficherProfil() {
        // Vérification si l'utilisateur est connecté
        if (!isset($_SESSION['user_id'])) {
            // Redirection vers la page de connexion
            header('Location: index.php?page=connexion');
            exit;
        }

        $userId = $_SESSION['user_id'];

        // Récupération des données du profil
        $profilData = $this->profilModel->getProfilById($userId);
        $login = $profilData['login']; // Récupérer le login

        // Récupération des informations supplémentaires de l'utilisateur
        $identiteData = $this->profilModel->getIdentiteByUserId($userId);

        $adresseData = $this->profilModel->getAdresseByUserId($userId);

        $campusData = $this->profilModel->getCampusInfoByUserId($userId);



        // Inclusion de la vue et passage des données
        include __DIR__ . '/../Views/profil.php';
    }






    /**
     * Traite la mise à jour des informations du profil
     */
    public function mettreAJourProfil() {
        // Vérification si l'utilisateur est connecté
        if (!isset($_SESSION['user_id'])) {
            echo json_encode(['success' => false, 'message' => 'Utilisateur non connecté']);
            exit;
        }

        $userId = $_SESSION['user_id'];

        // Récupération et nettoyage des données du formulaire
        $data = [
            'nom' => htmlspecialchars($_POST['nom'] ?? ''),
            'prenom' => htmlspecialchars($_POST['prenom'] ?? ''),
            'email' => filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL),
            'telephone' => htmlspecialchars($_POST['telephone'] ?? ''),
            'adresse' => htmlspecialchars($_POST['adresse'] ?? ''),
            'ville' => htmlspecialchars($_POST['ville'] ?? ''),
            'code_postal' => htmlspecialchars($_POST['code_postal'] ?? '')
        ];

        // Validation des données
        if (empty($data['email']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            echo json_encode(['success' => false, 'message' => 'Email invalide']);
            exit;
        }

        // Mise à jour du profil
        $success = $this->profilModel->updateProfil($userId, $data);

        // Gestion de la photo de profil si présente
        if (isset($_FILES['photo_profil']) && $_FILES['photo_profil']['error'] == 0) {
            $this->traiterPhotoProfile($userId);
        }

        // Réponse AJAX ou redirection
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            echo json_encode(['success' => $success]);
        } else {
            header('Location: index.php?page=profil&update=' . ($success ? 'success' : 'error'));
        }
    }

    /**
     * Traite l'upload de la photo de profil
     * @param int $userId ID de l'utilisateur
     */
    private function traiterPhotoProfile($userId) {
        $uploadDir = 'Views/img/uploads/profile/';
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        $maxSize = 2 * 1024 * 1024; // 2 Mo

        $file = $_FILES['photo_profil'];

        // Vérifications basiques
        if ($file['error'] !== 0) {
            return false;
        }

        if (!in_array($file['type'], $allowedTypes)) {
            return false;
        }

        if ($file['size'] > $maxSize) {
            return false;
        }

        // Génération d'un nom de fichier unique
        $fileExtension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $newFileName = uniqid('profile_') . '.' . $fileExtension;
        $uploadPath = $uploadDir . $newFileName;

        // Upload du fichier
        if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
            // Mise à jour du chemin dans la base de données
            $relativePath = 'img/uploads/profile/' . $newFileName;
            return $this->profilModel->updateProfilePhoto($userId, $relativePath);
        }

        return false;
    }
}
