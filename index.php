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

    case 'traitement':
        require_once 'controllers/TraitementController.php';
        $controller = new TraitementController();
        $controller->handleForm();
        exit;

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
