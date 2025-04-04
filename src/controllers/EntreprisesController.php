<?php
require_once 'src/models/Database.php';
require_once 'src/models/EntreprisesModel.php';

// Définir la fonction getLogoUrl dans un espace global, avant tout usage
if (!function_exists('getLogoUrl')) {
    function getLogoUrl($companyName) {
        // Transformer le nom en format compatible Clearbit
        $formattedName = strtolower(str_replace(' ', '', $companyName));
        $clearbitUrl = "https://logo.clearbit.com/$formattedName.com";

        // Vérifier si l'image existe
        $headers = @get_headers($clearbitUrl);
        if ($headers && strpos($headers[0], '200')) {
            return $clearbitUrl;
        }

        // Si aucun logo n'est trouvé, utiliser une image par défaut
        return "img/uploads/default.png";
    }
}

class EntreprisesController {
    private $model;
    private $pdo;

    // Propriété pour suivre si une vue a déjà été chargée
    private $viewLoaded = false;

    public function __construct() {
        $this->pdo = Database::getConnection();
        $this->model = new EntreprisesModel($this->pdo);
    }

    // Méthode pour charger une vue une seule fois
    private function loadViewOnce($viewPath, $data = []) {
        if ($this->viewLoaded) {
            return;
        }

        // Extraire les variables pour les rendre disponibles dans la vue
        extract($data);

        // Charger la vue
        include_once $viewPath;

        // Marquer que la vue a été chargée
        $this->viewLoaded = true;
    }

    // Afficher les entreprises avec pagination
    public function index_dashboard() {
        $entreprisesParPage = 10;
        $totalPages = $this->model->getTotalPages($entreprisesParPage);

        $pageActuelle = isset($_GET["page"]) && ctype_digit($_GET["page"]) && (int)$_GET["page"] > 0
            ? min((int)$_GET["page"], $totalPages)
            : 1;

        $entreprisesAffichees = $this->model->getEntreprisesAvecNotes($pageActuelle, $entreprisesParPage);

        $this->loadViewOnce('src/views/dashboard/entreprises/gestion-entreprises.php', [
            'entreprisesAffichees' => $entreprisesAffichees,
            'pageActuelle' => $pageActuelle,
            'totalPages' => $totalPages
        ]);
    }

    // Afficher les entreprises avec pagination
    public function index() {
        $entreprisesParPage = 8; // Nombre d'entreprises par page
        $totalPages = $this->model->getTotalPages($entreprisesParPage); // Calcul des pages

        $pageActuelle = 1;
        if (isset($_GET["page"])) {
            if (!ctype_digit($_GET["page"]) || (int)$_GET["page"] < 1) {
                die("Erreur : Numéro de page invalide.");
            }
            $pageActuelle = min((int)$_GET["page"], $totalPages);
        }

        // Récupérer les entreprises pour la page actuelle avec leurs notes
        $entreprisesAffichees = $this->model->getEntreprisesAvecNotes($pageActuelle, $entreprisesParPage);

        if (empty($entreprisesAffichees)) {
            echo "<p style='color: red;'>⚠️ Erreur : Aucun résultat trouvé.</p>";
        }

        $this->loadViewOnce('src/views/entreprises.php', [
            'entreprisesAffichees' => $entreprisesAffichees,
            'pageActuelle' => $pageActuelle,
            'totalPages' => $totalPages
        ]);
    }

    // Rechercher une entreprise
    public function recherche() {
        // Récupérer le terme de recherche
        $terme = isset($_GET['terme']) ? trim($_GET['terme']) : '';
        
        if (empty($terme)) {
            // Rediriger vers la liste complète si aucun terme n'est fourni
            header('Location: index.php?module=entreprises&action=index');
            exit;
        }
        
        // Effectuer la recherche
        $entreprisesAffichees = $this->model->rechercherEntreprises($terme);
        
        // Pour éviter des erreurs dans la vue
        $pageActuelle = 1;
        $totalPages = 1; // La recherche ne pagine pas, donc on met 1
        
        // Charger la vue avec les résultats
        $this->loadViewOnce('src/views/entreprises.php', [
            'entreprisesAffichees' => $entreprisesAffichees,
            'pageActuelle' => $pageActuelle,
            'totalPages' => $totalPages,
            'terme' => $terme
        ]);
    }

    // Rechercher une entreprise dans le dashboard
    public function recherche_dashboard() {
        // Récupérer le terme de recherche
        $terme = isset($_GET['terme']) ? trim($_GET['terme']) : '';
        
        if (empty($terme)) {
            // Rediriger vers la liste complète si aucun terme n'est fourni
            header('Location: index.php?module=entreprises&action=index_dashboard');
            exit;
        }
        
        // Effectuer la recherche
        $entreprisesAffichees = $this->model->rechercherEntreprisesDashboard($terme);
        
        // Pour éviter des erreurs dans la vue
        $pageActuelle = 1;
        $totalPages = 1; // La recherche ne pagine pas, donc on met 1
        
        // Charger la vue dashboard avec les résultats
        $this->loadViewOnce('src/views/dashboard/entreprises/gestion-entreprises.php', [
            'entreprisesAffichees' => $entreprisesAffichees,
            'pageActuelle' => $pageActuelle,
            'totalPages' => $totalPages,
            'terme' => $terme
        ]);
    }
    
    public function show($id) {
        if (!isset($id)) {
            header("Location: index.php?module=entreprises&action=index");
            exit;
        }

        // Récupérer les détails de l'entreprise à partir de l'ID
        $entreprise = $this->model->getById($id);

        if (!$entreprise) {
            $_SESSION['error'] = "Entreprise non trouvée.";
            header("Location: index.php?module=entreprises&action=index");
            exit;
        }

        // Récupérer le secteur de l'entreprise
        $secteur = $this->model->getSecteurById($entreprise['id_secteur']);

        // Récupérer les adresses de l'entreprise
        $adresses = $this->model->getAdressesByEntreprise($id);

        // Récupérer les offres de l'entreprise
        $offres = $this->model->getOffresByEntreprise($id);

        // Passer les données à la vue
        $this->loadViewOnce('src/views/détail-entreprise.php', [
            'entreprise' => $entreprise,
            'secteur' => $secteur,
            'adresses' => $adresses,
            'offres' => $offres
        ]);
    }

    // Afficher le formulaire de création d'entreprise
    public function create() {
        $secteurs = $this->model->getSecteursActivite();
        $this->loadViewOnce('src/views/dashboard/entreprises/ajout-entreprise.php', [
            'secteurs' => $secteurs
        ]);
    }

    // Enregistrer une nouvelle entreprise
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Récupérer les données du formulaire
            $nom_entreprise = $_POST['nom_entreprise'] ?? '';
            $id_secteur = $_POST['id_secteur'] ?? '';
            $id_fichier = $_POST['id_fichier'] ?? '';
            $is_visible = isset($_POST['is_visible']) ? 1 : 0;

            // Appeler la méthode du modèle pour créer l'entreprise
            $this->model->create($nom_entreprise, $id_secteur, $id_fichier, $is_visible);

            // Rediriger vers la page principale des entreprises
            header("Location: index.php?module=entreprises&action=index_dashboard");
            exit;
        }
    }

    // Afficher le formulaire de modification d'une entreprise
    public function edit($id) {
        // Récupérer l'entreprise à modifier
        $entreprise = $this->model->getById($id);

        if (!$entreprise) {
            die("Entreprise non trouvée.");
        }

        // Récupérer aussi la liste des secteurs
        $secteurs = $this->model->getSecteursActivite();

        $this->loadViewOnce('src/views/dashboard/entreprises/modif-entreprise.php', [
            'entreprise' => $entreprise,
            'secteurs' => $secteurs
        ]);
    }

    // Mettre à jour les informations d'une entreprise
    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Récupérer les données du formulaire
            $nom_entreprise = $_POST['nom_entreprise'] ?? '';
            $id_secteur = $_POST['id_secteur'] ?? '';
            $id_fichier = $_POST['id_fichier'] ?? '';
            $is_visible = isset($_POST['is_visible']) ? 1 : 0;

            // Appeler la méthode du modèle pour mettre à jour l'entreprise
            $this->model->update($id, $nom_entreprise, $id_secteur, $id_fichier, $is_visible);

            // Rediriger vers la page principale des entreprises
            header("Location: index.php?module=entreprises&action=index_dashboard");
            exit;
        }
    }

    // Supprimer une entreprise
    public function delete($id) {
        // Appeler la méthode du modèle pour supprimer l'entreprise
        $this->model->delete($id);

        // Rediriger vers la page principale des entreprises
        header("Location: index.php?module=entreprises&action=index_dashboard");
        exit;
    }

    // Toggle la visibilité d'une entreprise
    public function toggleVisibility($id) {
        $entreprise = $this->model->getById($id);

        if ($entreprise) {
            $nouvelleVisibilite = $entreprise['is_visible'] ? 0 : 1;
            $this->model->setVisibility($id, $nouvelleVisibilite);
        }

        // Redirection vers le dashboard après le changement
        header("Location: index.php?module=entreprises&action=index_dashboard");
        exit;
    }
}
