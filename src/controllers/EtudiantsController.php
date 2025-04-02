<?php

require_once 'src/models/Database.php';
require_once 'src/models/EtudiantsModel.php';

class EtudiantsController {
    private $model;

    public function __construct() {
        $pdo = Database::getConnection();
        $this->model = new EtudiantsModel($pdo);
    }

    public function index_dashboard() {
        $parPage = 10;
        $pageActuelle = isset($_GET['page']) && ctype_digit($_GET['page']) && (int)$_GET['page'] > 0
            ? (int)$_GET['page']
            : 1;

        $totalEtudiants = $this->model->countEtudiants();
        $totalPages = ceil($totalEtudiants / $parPage);

        $etudiants = $this->model->getEtudiantsPaginated($pageActuelle, $parPage);

        require 'src/views/dashboard/etudiants/gestion-etudiants.php';
    }

    public function delete() {
        if (isset($_GET['id'])) {
            $id = (int)$_GET['id'];
            $this->model->delete($id);
            header("Location: index.php?module=etudiants&action=index_dashboard");
            exit;
        } else {
            echo "Erreur : ID manquant.";
        }
    }

    public function edit() {
        if (isset($_GET['id'])) {
            $id = (int)$_GET['id'];
            $etudiant = $this->model->getById($id);
            if (!$etudiant) {
                die("Étudiant introuvable.");
            }
            require 'src/views/dashboard/etudiants/modif-etudiants.php';
        }
    }

    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id_utilisateur'] ?? null;
            $email = $_POST['email'] ?? '';
            $telephone = $_POST['telephone'] ?? '';
            $id_campus = $_POST['id_campus'] ?? '';

            if ($id) {
                $this->model->update($id, $email, $telephone, $id_campus);
                header("Location: index.php?module=etudiants&action=index_dashboard");
                exit;
            }
        }
    }

    public function getPassword() {
        if (isset($_GET['id'])) {
            $id = (int)$_GET['id'];
            $motDePasse = $this->model->getMotDePasse($id);
            
            // ⚠️ Pour des raisons de sécurité, ne fais ça que temporairement pour debug
            echo "Mot de passe hashé de l'étudiant #$id : <code>$motDePasse</code>";
        } else {
            echo "Erreur : ID manquant.";
        }
    }    
}
