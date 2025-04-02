<?php

require_once 'src/models/ProfilModel.php';

class ProfilController {
    private $model;
    private $pdo;

    public function __construct() {
        // Connexion à la base de données
        $this->pdo = Database::getConnection();
        $this->model = new ProfilModel($this->pdo);
    }

    public function index($userId) {
        // Récupérer les informations du profil utilisateur
        $profil = $this->model->getProfilById($userId);

        // Récupérer les informations supplémentaires de l'utilisateur
        $identiteData = $this->model->getIdentiteByUserId($userId);
        $adresseData = $this->model->getAdresseByUserId($userId);
        $campusData = $this->model->getCampusInfoByUserId($userId);

        // Récupérer le login de l'utilisateur
        $login = $profil['login'];  // Assurez-vous que 'login' est bien retourné par la méthode

        // Inclure la vue et passer les données
        require_once 'src/views/profil.php';
    }

}
