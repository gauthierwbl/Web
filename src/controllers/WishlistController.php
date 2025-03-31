<?php
require_once __DIR__ . '/../models/Database.php';
require_once __DIR__ . '/../models/WishlistModel.php';

class WishlistController {
    private $model;

    // Constructeur pour initialiser le modèle
    public function __construct($db) {
        $this->model = new WishlistModel($db);
    }

    // Ajouter une offre à la wishlist
    public function create($id_utilisateur, $id_offre) {
        $result = $this->model->create($id_utilisateur, $id_offre);
        return $result;
    }

    // Afficher la wishlist de l'utilisateur
    public function show($id_utilisateur) {
        $wishlist = $this->model->show($id_utilisateur);
        return $wishlist;
    }

    // Supprimer une offre de la wishlist
    public function delete($id_utilisateur, $id_offre) {
        $result = $this->model->delete($id_utilisateur, $id_offre);
        return $result;
    }
}
?>
