<?php
require_once __DIR__ . '/../models/Database.php';
require_once __DIR__ . '/../controllers/WishlistController.php';

// Créer une instance de la connexion à la base de données
$db = Database::getConnection();

// Créer une instance du contrôleur
$wishlistController = new WishlistController($db);

// Récupérer l'ID de l'utilisateur et de l'offre
$id_utilisateur = $_SESSION['id_utilisateur'];
$id_offre = $_POST['id_offre'];

// Supprimer l'offre de la wishlist
$wishlistController->removeFromWishlist($id_utilisateur, $id_offre);

// Rediriger l'utilisateur vers la wishlist
header("Location: wishlist.php");
exit;
?>
