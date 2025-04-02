<?php

require_once 'src/models/Database.php';
require_once 'src/models/WishlistModel.php';

class WishlistController {
    private $model;
    private $pdo;

    public function __construct() {
        session_start(); // obligatoire
        $_SESSION['id_utilisateur'] = 6; // Simuler un utilisateur
        $this->pdo = Database::getConnection();
        $this->model = new WishlistModel($this->pdo);
    }    

    public function index() {
        $userId = $_SESSION['id_utilisateur'] ?? null;
        if (!$userId) die("Utilisateur non connecté.");

        $offresParPage = 2;
        $pageActuelle = isset($_GET["page"]) && ctype_digit($_GET["page"]) && (int)$_GET["page"] > 0
            ? (int)$_GET["page"]
            : 1;

        $totalPages = $this->model->getTotalPages($userId, $offresParPage);
        $pageActuelle = min($pageActuelle, $totalPages);

        $offres = $this->model->getWishlistByUser($userId, $pageActuelle, $offresParPage);

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
