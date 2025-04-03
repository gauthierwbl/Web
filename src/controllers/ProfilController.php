<?php

require_once 'src/models/ProfilModel.php';
require_once 'src/models/Database.php';

class ProfilController {
    private $model;
    private $pdo;

    public function __construct() {
        // Connexion à la base de données
        $this->pdo = (new Database())->getConnection();
        $this->model = new ProfilModel($this->pdo);
    }

    // Méthode index sans paramètre qui récupère l'ID de la session
    public function index() {
        // Vérifier que l'utilisateur est connecté
        if (!isset($_SESSION['user'])) {
            $_SESSION['error'] = "Veuillez vous connecter pour accéder à votre profil.";
            header('Location: index.php?module=auth&action=showLoginForm');
            exit;
        }

        // Récupérer l'ID utilisateur depuis la session comme dans WishlistController
        $userId = $_SESSION['id_utilisateur'] ?? null;

        // Si l'ID n'est pas disponible dans la session, utiliser les données de l'utilisateur
        if (!$userId && isset($_SESSION['user']['id_utilisateurs'])) {
            $userId = $_SESSION['user']['id_utilisateurs'];

            // Stocker l'ID dans la session pour la cohérence
            $_SESSION['id_utilisateur'] = $userId;
        }

        // Si toujours pas d'ID, essayer avec le login
        if (!$userId && isset($_SESSION['user']['login'])) {
            $userLogin = $_SESSION['user']['login'];
            $userId = $this->getUserIdFromLogin($userLogin);

            // Stocker l'ID pour les futures requêtes
            if ($userId) {
                $_SESSION['id_utilisateur'] = $userId;
            }
        }

        if (!$userId) {
            $_SESSION['error'] = "Utilisateur non trouvé.";
            header('Location: index.php?module=auth&action=showLoginForm');
            exit;
        }

        // Debug - Afficher l'ID utilisateur
        error_log("index - userId: $userId");

        // Maintenant que nous avons l'ID utilisateur, continuer avec le reste du code...
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
        if (!$profil) {
            $_SESSION['error'] = "Profil non trouvé.";
            header('Location: index.php');
            exit;
        }

        // Le reste de la fonction reste inchangé...
        $identiteData = $this->model->getIdentiteByUserId($userId);
        $adresseData = $this->model->getAdresseByUserId($userId);
        $campusData = $this->model->getCampusInfoByUserId($userId);

        // S'assurer que les méthodes de statistiques reçoivent bien l'ID utilisateur
        $wishlistCount = $this->model->getWishlistCount($userId);
        $completedInternshipsCount = $this->model->getCompletedInternshipsCount($userId);
        $applicationsCount = $this->model->getApplicationsCount($userId);

        // Debug - Afficher les compteurs
        error_log("Compteurs - wishlist: $wishlistCount, completed: $completedInternshipsCount, applications: $applicationsCount");

        $profilePhoto = $this->model->getProfilePhoto($userId);
        $login = $profil['login'];

        // Inclure la vue et passer les données
        require_once 'src/views/profil.php';
    }

    /**
     * Récupère l'ID utilisateur à partir du login
     */
    private function getUserIdFromLogin($login) {
        try {
            $stmt = $this->pdo->prepare("SELECT id_utilisateurs FROM utilisateurs WHERE login = :login LIMIT 1");
            $stmt->bindParam(':login', $login, PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            // Debug
            error_log("getUserIdFromLogin - login: $login, result: " . print_r($result, true));

            return $result ? $result['id_utilisateurs'] : null;
        } catch (PDOException $e) {
            error_log("Erreur dans getUserIdFromLogin: " . $e->getMessage());
            return null;
        }
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

            // Créer le répertoire s'il n'existe pas
            if (!file_exists($targetDirectory)) {
                mkdir($targetDirectory, 0777, true);
            }

            $targetFile = $targetDirectory . 'id' . $userId . 'profil.png';

            // Tenter de déplacer le fichier
            if (move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $targetFile)) {
                // Succès, rediriger pour éviter la résoumission
                $_SESSION['success'] = "Photo de profil mise à jour avec succès.";
                header('Location: index.php?module=profil&action=index');
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
                // Si le login a été modifié, mettre à jour la session
                if (isset($updateData['login'])) {
                    $_SESSION['user']['login'] = $updateData['login'];
                }

                $_SESSION['success'] = "Profil mis à jour avec succès.";
            } else {
                $_SESSION['error'] = "Erreur lors de la mise à jour du profil.";
            }
        }

        // Rediriger pour éviter la résoumission
        header('Location: index.php?module=profil&action=index');
        exit;
    }
}