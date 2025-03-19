<?php

require_once 'config/config.php';
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

// Gestion du routage
if (array_key_exists($request, $routes)) {
    $controllerName = "Controllers\\" . $routes[$request]['controller'];
    $method = $routes[$request]['method'];
    
    if (class_exists($controllerName)) {
        $controller = new $controllerName($dbConnection);
        if (method_exists($controller, $method)) {
            $controller->$method();
        } else {
            http_response_code(404);
            echo "Méthode non trouvée";
        }
    } else {
        http_response_code(404);
        echo "Contrôleur non trouvé";
    }
} else {
    http_response_code(404);
    echo "Page non trouvée";
}
