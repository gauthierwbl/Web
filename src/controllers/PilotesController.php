<?php

require_once 'src/models/Database.php';
require_once 'src/models/PilotesModel.php';

class PilotesController {
    private $model;

    public function __construct() {
        $pdo = Database::getConnection();
        $this->model = new PilotesModel($pdo);
    }

    public function index_dashboard() {
        $parPage = 10;
        $pageActuelle = isset($_GET['page']) && ctype_digit($_GET['page']) && $_GET['page'] > 0 ? (int)$_GET['page'] : 1;

        $total = $this->model->countPilotes();
        $totalPages = ceil($total / $parPage);

        $pilotes = $this->model->getPilotesPaginated($pageActuelle, $parPage);

        require 'src/views/dashboard/pilotes/gestion-pilotes.php';
    }

    public function create() {
        $villes = $this->model->getVilles();
        require 'src/views/dashboard/pilotes/ajout-pilote.php';
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $login = $_POST['login'] ?? '';
            $mot_de_passe = $_POST['mot_de_passe'] ?? '';
            $adresse = $_POST['adresse'] ?? '';
            $id_ville = $_POST['id_ville'] ?? '';
            $nom = $_POST['nom'] ?? '';
            $prenom = $_POST['prenom'] ?? '';

            if ($login && $mot_de_passe && $adresse && $id_ville && $nom && $prenom) {
                $hash = password_hash($mot_de_passe, PASSWORD_DEFAULT);
                $this->model->create($login, $hash, $nom, $prenom, $adresse, $id_ville);
                header("Location: index.php?module=pilotes&action=index_dashboard");
                exit;
            } else {
                $erreur = "Tous les champs sont requis.";
                $villes = $this->model->getVilles();
                require 'src/views/dashboard/pilotes/ajout-pilote.php';
            }
        }
    }

    public function edit($id) {
        $pilote = $this->model->getById($id);
        $villes = $this->model->getVilles();

        if (!$pilote) {
            die("Pilote introuvable.");
        }

        require 'src/views/dashboard/pilotes/modif-pilote.php';
    }

    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id_utilisateur'] ?? null;
            $login = $_POST['login'] ?? '';
            $mot_de_passe = $_POST['mot_de_passe'] ?? '';
            $adresse = $_POST['adresse'] ?? '';
            $id_ville = $_POST['id_ville'] ?? '';
            $nom = $_POST['nom'] ?? '';
            $prenom = $_POST['prenom'] ?? '';

            if ($id && $login && $adresse && $id_ville && $nom && $prenom) {
                $hash = !empty($mot_de_passe) ? password_hash($mot_de_passe, PASSWORD_DEFAULT) : null;
                $this->model->update($id, $login, $hash, $nom, $prenom, $adresse, $id_ville);
                header("Location: index.php?module=pilotes&action=index_dashboard");
                exit;
            } else {
                echo "Tous les champs sont requis pour la modification.";
            }
        }
    }

    public function delete($id) {
        $this->model->delete($id);
        header("Location: index.php?module=pilotes&action=index_dashboard");
        exit;
    }
}
