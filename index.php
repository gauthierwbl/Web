<?php

session_start();

// Inclure le modèle UserModel et la connexion à la base de données
require_once 'src/models/Database.php';
require_once 'src/models/UserModel.php';

// Connexion à la BDD
$pdo = (new Database())->getConnection();

// Détermination du module et de l'action
$module = $_GET['module'] ?? 'auth';
$action = $_GET['action'] ?? 'showLoginForm';

// Si l'utilisateur n'est pas connecté et tente d'accéder à autre chose que le module auth
if (!isset($_SESSION['user']) && $module !== 'auth') {
    // Rediriger vers la page de connexion
    header('Location: index.php?module=auth&action=showLoginForm');
    exit;
}

// Si l'utilisateur est connecté, chargement des styles
if (isset($_SESSION['user'])) {
    echo '<head>';
    echo '<link rel="stylesheet" href="src/Views/css/styles.css">';
    echo '<link rel="stylesheet" href="src/Views/css/animate.min.css">';
    echo '<link rel="stylesheet" href="src/Views/css/style-admin.css">';
    echo '<link rel="stylesheet" href="src/Views/css/Footer-Basic-icons.css">';
    echo '</head>';
}

$controller = null; // Par défaut, il n'y a pas de contrôleur

// Instanciation du bon contrôleur et exécution de l'action
switch ($module) {
    case 'auth':
        require_once 'src/controllers/AuthController.php';
        $controller = new AuthController($pdo);
        break;

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
        
    case 'candidatures':
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
        $controller = new ProfilController();

        // Si aucune action n'est spécifiée, utiliser 'index' par défaut
        if (!isset($_GET['action']) || empty($_GET['action'])) {
            $action = 'index';
        }
        break;

    case 'Traitement':
        require_once 'src/controllers/TraitementController.php';
        $controller = new TraitementController();
        break;

    default:
        header('Location: index.php?module=auth&action=showLoginForm');
        exit;
}

// Après le switch, vérifiez que $controller est défini avant de l'utiliser
if (is_null($controller)) {
    die("Contrôleur introuvable pour le module : $module");
}

// Exécution de l'action
if (method_exists($controller, $action)) {
    if (in_array($action, ['edit', 'update', 'delete', 'toggleVisibility']) && isset($_GET['id'])) {
        $controller->$action($_GET['id']);
    } else {
        $controller->$action();
    }
} else {
    die("Action introuvable : $action");
}