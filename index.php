<?php

echo '<head>';
echo '<link rel="stylesheet" href="src/Views/css/styles.css">';
echo '<link rel="stylesheet" href="src/Views/css/animate.min.css">';
echo '<link rel="stylesheet" href="src/Views/css/style-admin.css">';
echo '<link rel="stylesheet" href="src/Views/css/Footer-Basic-icons.css">';

echo '</head>';

require_once 'src/models/Database.php';


// Connexion à la BDD
$pdo = (new Database())->getConnection();



// Détermination du module et de l'action
$module = $_GET['module'] ?? 'offres';  
$action = $_GET['action'] ?? 'index';

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

    case 'Wishlist':
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


    default:
        die("Module inconnu : $module");
}

// Exécution de l'action
if (method_exists($controller, $action)) {
    if (in_array($action, ['edit', 'update', 'delete']) && isset($_GET['id'])) {
        $controller->$action($_GET['id']);
    } else {
        $controller->$action();
    }
} else {
    die("Action inconnue : $action");
}
?>
