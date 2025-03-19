<?php

/*
require_once 'config/config.php';

// Autoload des classes
spl_autoload_register(function ($class) {
    $file = 'app/' . str_replace('\\', '/', $class) . '.php';
    if (file_exists($file)) {
        require_once $file;
    }
});

// Initialisation de la connexion à la base de données
$dbConnection = new DatabaseConnection();

// Démarrer la session
session_start();
*/

// Récupération de l'URL demandée
$request = $_SERVER['REQUEST_URI'];

// Définition des routes
$routes = [
    '/etudiants' => ['controller' => 'EtudiantController', 'method' => 'index'],
    '/etudiants/create' => ['controller' => 'EtudiantController', 'method' => 'create'],
    '/etudiants/edit' => ['controller' => 'EtudiantController', 'method' => 'edit'],
    '/etudiants/delete' => ['controller' => 'EtudiantController', 'method' => 'delete'],
    
    '/pilotes' => ['controller' => 'PiloteController', 'method' => 'index'],
    '/pilotes/create' => ['controller' => 'PiloteController', 'method' => 'create'],
    '/pilotes/edit' => ['controller' => 'PiloteController', 'method' => 'edit'],
    '/pilotes/delete' => ['controller' => 'PiloteController', 'method' => 'delete'],

    '/candidature' => ['controller' => 'CandidatureController', 'method' => 'index'], 
    '/candidatures/create' => ['controller' => 'CandidatureController', 'method' => 'create'], 
    '/candidatures/edit/{id}' => ['controller' => 'CandidatureController', 'method' => 'edit'], 
    '/candidatures/delete/{id}' => ['controller' => 'CandidatureController', 'method' => 'delete'], 
    '/candidatures/show/{id}' => ['controller' => 'CandidatureController', 'method' => 'show'], 
    
    '/entreprise' => ['controller' => 'EntrepriseController', 'method' => 'index'], 
    '/entreprises/create' => ['controller' => 'EntrepriseController', 'method' => 'create'], 
    '/entreprises/edit/{id}' => ['controller' => 'EntrepriseController', 'method' => 'edit'],
    '/entreprises/delete/{id}' => ['controller' => 'EntrepriseController', 'method' => 'delete'], 
    '/entreprises/show/{id}' => ['controller' => 'EntrepriseController', 'method' => 'show'], 

    '/stages' => ['controller' => 'StageController', 'method' => 'index'],
    '/stages/create' => ['controller' => 'StageController', 'method' => 'create'], 
    '/stages/edit/{id}' => ['controller' => 'StageController', 'method' => 'edit'], 
    '/stages/delete/{id}' => ['controller' => 'StageController', 'method' => 'delete'], 
    '/stages/show/{id}' => ['controller' => 'StageController', 'method' => 'show'], 

    '/statistiques' => ['controller' => 'StatisticalDashboardController', 'method' => 'index'], 
    '/statistiques/show/{id}' => ['controller' => 'StatisticalDashboardController', 'method' => 'show'], 
    
    '/' => ['controller' => 'HomeController', 'method' => 'index']
];

// Fonction pour extraire les paramètres dynamiques
function matchRouteWithParams($request, $routes) {
    foreach ($routes as $route => $controllerData) {
        // Convertir la route en expression régulière
        $routePattern = preg_replace('/{(\w+)}/', '(\d+)', $route);  // Remplace les paramètres dynamiques par des groupes de capture
        $routePattern = '#^' . $routePattern . '$#'; // Ajoute les délimiteurs de début et de fin de chaîne

        if (preg_match($routePattern, $request, $matches)) { // Teste la correspondance de l'URL avec la route
            // Extraire les paramètres
            array_shift($matches); // Supprimer le premier élément (qui est l'URL correspondante)
            return [
                'controller' => $controllerData['controller'], // Nom du contrôleur à appeler
                'method' => $controllerData['method'], // Méthode à appeler dans le contrôleur
                'params' => $matches // Paramètres extraits de l'URL
            ];
        }
    }
    return null; // Si aucune correspondance n'est trouvée
}

// Gestion du routage avec paramètres dynamiques
$routeData = matchRouteWithParams($request, $routes);

if ($routeData) {
    $controllerName = "Controllers\\" . $routeData['controller']; // Construction du nom complet du contrôleur
    $method = $routeData['method']; // Récupération du nom de la méthode

    if (class_exists($controllerName)) { // Vérifie si le contrôleur existe
        $controller = new $controllerName($dbConnection); // Création de l'instance du contrôleur
        if (method_exists($controller, $method)) { // Vérifie si la méthode existe
            call_user_func_array([$controller, $method], $routeData['params']); // Appel de la méthode avec les paramètres
        } else {
            http_response_code(404);
            echo "Méthode non trouvée"; // Gestion d'erreur si la méthode n'existe pas
        }
    } else {
        http_response_code(404);
        echo "Contrôleur non trouvé"; // Gestion d'erreur si le contrôleur n'existe pas
    }
} else {
    http_response_code(404);
    echo "Page non trouvée"; // Gestion d'erreur si aucune route ne correspond
}
?>
