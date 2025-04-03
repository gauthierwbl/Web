<?php

require_once 'src/models/Database.php';
require_once 'src/models/WishlistModel.php';

/**
 * Classe WishlistController
 * Gère les fonctionnalités de wishlist pour les utilisateurs
 */
class WishlistController {
    private $model;
    private $pdo;

    /**
     * Constructeur
     */
    public function __construct() {
        // Démarrer la session si ce n'est pas déjà fait
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        // Définir un utilisateur par défaut pour les tests si nécessaire
        if (!isset($_SESSION['id_utilisateur'])) {
            $_SESSION['id_utilisateur'] = 6; // ID par défaut
        }

        // Initialiser la connexion à la base de données et le modèle
        $this->pdo = Database::getConnection();
        $this->model = new WishlistModel($this->pdo);
    }

    /**
     * Affiche la liste des offres dans la wishlist
     */
    public function index() {
        // Récupérer l'ID utilisateur
        $userId = $_SESSION['id_utilisateur'] ?? null;

        // Si l'utilisateur n'est pas connecté, rediriger
        if (!$userId) {
            $_SESSION['error'] = "Vous devez être connecté pour accéder à votre wishlist.";
            header("Location: index.php"); // Page d'accueil ou de connexion
            exit;
        }

        // Pagination
        $offresParPage = 4;
        $pageActuelle = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
        $pageActuelle = max(1, $pageActuelle);

        // Récupérer le nombre total de pages
        $totalPages = $this->model->getTotalPages($userId, $offresParPage);
        $pageActuelle = min($pageActuelle, max(1, $totalPages));

        // Récupérer les offres
        $offres = $this->model->getWishlistByUser($userId, $pageActuelle, $offresParPage);

        // Charger la vue
        require_once 'src/views/wishlist.php';
    }

    /**
     * Ajoute une offre à la wishlist
     */
    public function add() {
        // Récupérer les paramètres
        $userId = $_SESSION['id_utilisateur'] ?? null;
        $offreId = isset($_GET['id']) ? (int)$_GET['id'] : null;

        // Vérifier les données
        if (!$userId || !$offreId) {
            $_SESSION['error'] = "Impossible d'ajouter cette offre à votre wishlist.";
            $this->redirect();
            return;
        }

        // Ajouter l'offre
        if ($this->model->addToWishlist($userId, $offreId)) {
            $_SESSION['success'] = "Offre ajoutée à votre wishlist.";
        } else {
            $_SESSION['error'] = "Erreur lors de l'ajout de l'offre à votre wishlist.";
        }

        // Rediriger
        $this->redirect($_GET['redirect'] ?? null, $offreId);
    }

    /**
     * Supprime une offre de la wishlist
     */
    public function delete() {
        // Récupérer les paramètres
        $userId = $_SESSION['id_utilisateur'] ?? null;
        $offreId = isset($_GET['id']) ? (int)$_GET['id'] : null;

        // Vérifier les données
        if (!$userId || !$offreId) {
            $_SESSION['error'] = "Impossible de supprimer cette offre de votre wishlist.";
            $this->redirect();
            return;
        }

        // Supprimer l'offre
        if ($this->model->removeFromWishlist($userId, $offreId)) {
            $_SESSION['success'] = "Offre supprimée de votre wishlist.";
        } else {
            $_SESSION['error'] = "Erreur lors de la suppression de l'offre de votre wishlist.";
        }

        // Rediriger
        $this->redirect($_GET['redirect'] ?? null, $offreId);
    }

    /**
     * Méthode utilitaire pour la redirection
     * @param string $redirect Type de redirection (details, index, etc.)
     * @param int $offreId ID de l'offre (pour les redirections vers les détails)
     */
    private function redirect($redirect = null, $offreId = null) {
        // Rediriger en fonction du paramètre redirect
        if ($redirect === 'details' && $offreId) {
            header("Location: index.php?module=offres&action=details&id=$offreId");
        } else if ($redirect === 'wishlist') {
            header("Location: index.php?module=wishlist&action=index");
        } else {
            // Redirection par défaut : utiliser le referer ou retourner à la liste des offres
            $referer = $_SERVER['HTTP_REFERER'] ?? null;
            header("Location: " . ($referer ?: "index.php?module=offres&action=index"));
        }
        exit;
    }

    /**
     * Vérifie si la table ajouter_wishlist existe et la crée si nécessaire
     */
    public function setup() {
        try {
            // Vérifier si la table existe
            $tableExists = $this->pdo->query("
                SELECT COUNT(*) 
                FROM information_schema.tables 
                WHERE table_schema = DATABASE() 
                AND table_name = 'ajouter_wishlist'
            ")->fetchColumn();

            if (!$tableExists) {
                // Créer la table avec une structure simplifiée
                $this->pdo->exec("
                    CREATE TABLE `ajouter_wishlist` (
                      `id_utilisateurs` int(11) NOT NULL,
                      `id_offre` int(11) NOT NULL,
                      PRIMARY KEY (`id_utilisateurs`, `id_offre`)
                    )
                ");

                echo "<div style='background: #d4edda; color: #155724; padding: 15px; margin: 15px 0; border-radius: 4px;'>
                        Table 'ajouter_wishlist' créée avec succès !
                    </div>";
            } else {
                echo "<div style='background: #d1ecf1; color: #0c5460; padding: 15px; margin: 15px 0; border-radius: 4px;'>
                        La table 'ajouter_wishlist' existe déjà.
                    </div>";
            }

            echo "<p><a href='index.php?module=wishlist&action=index'>Aller à la wishlist</a></p>";

        } catch (PDOException $e) {
            echo "<div style='background: #f8d7da; color: #721c24; padding: 15px; margin: 15px 0; border-radius: 4px;'>
                    Erreur : " . $e->getMessage() . "
                </div>";
        }
    }
}
?>