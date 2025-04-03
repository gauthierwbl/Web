<?php

session_start();

// Inclure le modèle UserModel et la connexion à la base de données
require_once 'src/models/Database.php';
require_once 'src/models/UserModel.php';

// Connexion à la BDD
$pdo = (new Database())->getConnection();
$userModel = new UserModel($pdo);

// Vérification de l'authentification avant de continuer
if (!isset($_SESSION['user'])) {
    // Si une tentative de connexion est en cours
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = $_POST['login'] ?? '';
        $password = $_POST['password'] ?? '';

        // Recherche de l'utilisateur dans la BDD
        $user = $userModel->findUserByUsername($username);

        // Si utilisateur trouvé et mot de passe correct
        if ($user && password_verify($password, $user['mot_de_passe'])) {
            $_SESSION['user'] = $user;
            header('Location: index.php'); // Redirection après connexion réussie
            exit;
        } else {
            // Sinon, on affiche un message d'erreur et le formulaire de connexion
            $error = "Identifiants incorrects.";
        }
    }
    include 'src/views/connexion.php';
}

// Si l'utilisateur est connecté, continuer le reste du code
echo '<head>';
echo '<link rel="stylesheet" href="src/Views/css/styles.css">';
echo '<link rel="stylesheet" href="src/Views/css/animate.min.css">';
echo '<link rel="stylesheet" href="src/Views/css/style-admin.css">';
echo '<link rel="stylesheet" href="src/Views/css/Footer-Basic-icons.css">';
echo '</head>';

// Détermination du module et de l'action
$module = $_GET['module'] ?? 'login';
$action = $_GET['action'] ?? 'index';
$controller = null; // Par défaut, il n'y a pas de contrôleur

// Instanciation du bon contrôleur et exécution de l'action
switch ($module) {
    case 'entreprises':
        require_once 'src/controllers/EntreprisesController.php';
        $controller = new EntreprisesController();
        break;

    case 'offres':
        require_once 'src/controllers/OffresController.php';
        $controller = new OffresController();
        break;
        
    case 'Stages':
        require_once 'src/controllers/StagesController.php';
        $controller = new StagesController();
        break;

    case 'wishlist':
        require_once 'src/controllers/WishlistController.php';
        $controller = new WishlistController();
        break;   
        
    case 'Evaluation':
        require_once 'src/controllers/EvaluationController.php';
        $controller = new EvaluationController();
        break;  

    case 'Statistiques':
        require_once 'src/controllers/StatistiquesController.php';
        $controller = new StatistiquesController();
        break;

    case 'Contact':
        require_once 'src/controllers/ContactController.php';
        $controller = new ContactController();
        break;  
        
    case 'Candidature':
        require_once 'src/controllers/CandidatureController.php';
        $controller = new CandidatureController();
        break;

    case 'etudiants':
        require_once 'src/controllers/EtudiantsController.php';
        $controller = new EtudiantsController();
        break;

    case 'pilotes':
        require_once 'src/controllers/PilotesController.php';
        $controller = new PilotesController();
        break;

    case 'profil':
        // Inclure le contrôleur Profil
        require_once 'src/controllers/ProfilController.php';

        // Vérifier si l'ID de l'utilisateur est passé dans l'URL
        if (isset($_GET['id'])) {
            $userId = $_GET['id'];  // Récupérer l'ID de l'utilisateur

            // Créer une instance du contrôleur ProfilController
            $controller = new ProfilController();

            // Appeler la méthode index() avec l'ID de l'utilisateur
            $controller->index($userId);
        } else {
            // Si l'ID n'est pas passé, afficher une erreur ou rediriger
            echo "ID de l'utilisateur manquant.";
        }
        break;

    case 'Traitement':
        require_once 'src/controllers/TraitementController.php';
        $controller = new TraitementController();
        break;

    case 'login':
        // Aucun contrôleur spécifique pour le login
        require_once 'src/controllers/LoginControlleur.php';
        // Redirection ou formulaire géré directement plus haut
        $controller = new LoginControlleur();
        break;

    default:
        die();
}

// Après le switch, vérifiez que $controller est défini avant de l'utiliser
if (is_null($controller)) {
    die("Contrôleur introuvable pour le module : $module");
}

// Exécution de l'action
if (method_exists($controller, $action)) {
    if (in_array($action, ['edit', 'update', 'delete']) && isset($_GET['id'])) {
        $controller->$action($_GET['id']);
    } else {
        $controller->$action();
    }
} else {
    die();
}
