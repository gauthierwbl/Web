<?php

require_once 'Models/DatabaseConnection.php';
require_once 'Models/UserModel.php';  
require_once 'Models/StageModel.php'; 
require_once 'Models/EntrepriseModel.php';

class StatisticalDashboardController extends BaseController {
    private $userModel;
    private $stageModel;
    private $entrepriseModel;

    // Constructeur pour initialiser la connexion à la base de données et les modèles
    public function __construct() {
        // Crée une instance de DatabaseConnection et connecte-la
        $dbConnection = new DatabaseConnection();
        $dbConnection->connect();
        
        // Crée les instances des modèles en passant la connexion à la base de données
        $this->userModel = new UserModel($dbConnection);
        $this->stageModel = new StageModel($dbConnection);
        $this->entrepriseModel = new EntrepriseModel($dbConnection);
        
        // Appelle le constructeur parent avec un modèle spécifique (si nécessaire, sinon utiliser une instance pour chaque modèle)
        parent::__construct($this->userModel); // Exemple, ici on peut passer le modèle utilisateur ou un autre modèle.
    }

    // Affiche le tableau de bord des statistiques
    public function index() {
        // Récupère les statistiques globales depuis le modèle
        $statistics = $this->getStatistics(); // Si la méthode 'getStatistics' est définie dans un des modèles ou dans un service
        $this->view->render('dashboard/statistiques', ['statistics' => $statistics]);
    }

    // Affiche une statistique spécifique
    public function show($id) {
        // Récupère les données de la statistique spécifique
        $stat = $this->getStatById($id); // Similaire à 'getStatistics' mais pour une statistique spécifique
        $this->view->render('dashboard/statistiques', ['stat' => $stat]);
    }

    // Méthode pour récupérer les statistiques globales
    private function getStatistics() {
        // On peut récupérer les statistiques via les différents modèles, par exemple :
        $userStats = $this->userModel->getUserStatistics();
        $stageStats = $this->stageModel->getStageStatistics();
        $entrepriseStats = $this->entrepriseModel->getEntrepriseStatistics();

        // Combine les résultats selon la logique métier
        return [
            'userStats' => $userStats,
            'stageStats' => $stageStats,
            'entrepriseStats' => $entrepriseStats
        ];
    }

    // Méthode pour récupérer une statistique spécifique
    private function getStatById($id) {
        // Exemple de récupération de statistiques spécifiques via un modèle ou en effectuant des calculs basés sur les données
        return $this->userModel->getStatById($id);
    }
}
