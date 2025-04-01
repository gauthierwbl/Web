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
$module = $_GET['module'] ?? 'offres';  // Par défaut, afficher les offres
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

    case 'contact':
        require_once 'src/Views/contact.php';
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
