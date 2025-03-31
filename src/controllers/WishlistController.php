<?php

require_once 'src/models/Database.php';
require_once 'src/models/WishlistModel.php';

class WishlistController {
    private $model;

    public function __construct() {
        session_start(); // obligatoire si ce n'est pas déjà fait
        $_SESSION['id_utilisateurs'] = 1; // <--- utilisateur simulé
        $this->pdo = Database::getConnection();
        $this->model = new WishlistModel($this->pdo);
    }    

    public function index() {
        $userId = $_SESSION['id_utilisateur'] ?? null;
        if (!$userId) die("Utilisateur non connecté.");

        $offres = $this->model->getWishlistByUser($userId);
        require 'src/views/wishlist.php';
    }

    public function add() {
        $userId = $_SESSION['id_utilisateur'] ?? null;
        $id_offre = $_GET['id'] ?? null;
        if ($userId && $id_offre) {
            $this->model->addToWishlist($userId, $id_offre);
        }
        header("Location: index.php?module=offres&action=index");
        exit;
    }

    public function delete() {
        $userId = $_SESSION['id_utilisateur'] ?? null;
        $id_offre = $_GET['id'] ?? null;
        if ($userId && $id_offre) {
            $this->model->removeFromWishlist($userId, $id_offre);
        }
        header("Location: index.php?module=wishlist&action=index");
        exit;
    }
}
?>
