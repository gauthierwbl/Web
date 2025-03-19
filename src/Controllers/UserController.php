<?php

require_once 'Models/DatabaseConnection.php';
require_once 'Models/UserModel.php';

class UserController extends BaseController {
    private $userModel;

    // Constructeur pour initialiser les modèles et les connecter à la base de données
    public function __construct() {
        // Crée une instance de DatabaseConnection et connecte-la
        $dbConnection = new DatabaseConnection();
        $dbConnection->connect();
        
        // Crée une instance du modèle UserModel et passe la connexion à la base de données
        $this->userModel = new UserModel($dbConnection);
        
        // Appelle le constructeur parent avec le modèle UserModel
        parent::__construct($this->userModel);
    }

    // Affiche la liste des étudiants et des pilotes
    public function index() {
        // Récupère tous les étudiants et pilotes depuis le modèle
        $etudiants = $this->userModel->getAllEtudiants();
        $pilotes = $this->userModel->getAllPilotes();
        
        // Rendu des vues des étudiants et des pilotes
        $this->view->render('/dashboard/etudiants/gestion-etudiants', ['etudiants' => $etudiants]);
        $this->view->render('/dashboard/pilotes/gestion-pilotes', ['pilotes' => $pilotes]);
    }

    // Crée un nouvel étudiant ou pilote
    public function create($type = 'etudiant') {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $_POST;
            
            // Crée un utilisateur en fonction du type (étudiant ou pilote)
            if ($type === 'pilote') {
                $this->userModel->createPilote($data); // Crée un pilote
            } else {
                $this->userModel->createEtudiant($data); // Crée un étudiant
            }

            // Redirige vers la liste des utilisateurs après la création
            header('Location: /dashboard/statistiques');
            exit;
        }

        // Rendu de la vue de création d'utilisateur (étudiant ou pilote)
        if ($type === 'pilote') {
            $this->view->render('/dashboard/etudiants/ajout-pilotes'); // Vue pour créer un pilote
        } else {
            $this->view->render('/dashboard/etudiants/ajout-etudiants'); // Vue pour créer un étudiant
        }
    }

    // Modifie un étudiant ou un pilote existant
    public function edit($id, $type = 'etudiant') {
        // Récupère l'utilisateur en fonction du type (étudiant ou pilote)
        if ($type === 'pilote') {
            $user = $this->userModel->getPiloteById($id); // Récupère un pilote
        } else {
            $user = $this->userModel->getEtudiantById($id); // Récupère un étudiant
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $_POST;
            
            // Met à jour l'utilisateur en fonction du type
            if ($type === 'pilote') {
                $this->userModel->updatePilote($id, $data); // Met à jour un pilote
            } else {
                $this->userModel->updateEtudiant($id, $data); // Met à jour un étudiant
            }

            // Redirige vers la liste des utilisateurs après la mise à jour
            header('Location: /dashboard/statistiques');
            exit;
        }

        // Rendu de la vue de modification d'utilisateur (étudiant ou pilote)
        if ($type === 'pilote') {
            $this->view->render('/dashboard/etudiants/gestion-pilotes', ['user' => $user]); // Vue pour modifier un pilote
        } else {
            $this->view->render('/dashboard/etudiants/gestion-etudiants', ['user' => $user]); // Vue pour modifier un étudiant
        }
    }

    // Supprime un étudiant ou un pilote
    public function delete($id, $type = 'etudiant') {
        // Supprime l'utilisateur en fonction du type (étudiant ou pilote)
        if ($type === 'pilote') {
            $this->userModel->deletePilote($id); // Supprime un pilote
        } else {
            $this->userModel->deleteEtudiant($id); // Supprime un étudiant
        }

        // Redirige vers la liste des utilisateurs après la suppression
        header('Location: /dashboard/statistiques');
        exit;
    }

    // Affiche les détails d'un étudiant ou pilote spécifique
    public function show($id, $type = 'etudiant') {
        // Récupère les détails de l'utilisateur en fonction du type
        if ($type === 'pilote') {
            $user = $this->userModel->getPiloteById($id); // Récupère un pilote
        } else {
            $user = $this->userModel->getEtudiantById($id); // Récupère un étudiant
        }

        // Rendu de la vue avec les détails de l'utilisateur
        if ($type === 'pilote') {
            $this->view->render('/dashboard/etudiants/gestion-pilotes', ['user' => $user]); // Vue pour afficher un pilote
        } else {
            $this->view->render('/dashboard/etudiants/gestion-etudiants', ['user' => $user]); // Vue pour afficher un étudiant
        }
    }
}
