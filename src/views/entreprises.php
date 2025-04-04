<?php
// Empêcher l'exécution directe du fichier
defined('APP_LOADED') or define('APP_LOADED', true);

// Fonction getLogoUrl définie si elle n'existe pas déjà
if (!function_exists('getLogoUrl')) {
    function getLogoUrl($companyName) {
        // Transformer le nom en format compatible Clearbit (suppression des espaces, minuscules)
        $formattedName = strtolower(str_replace(' ', '', $companyName));
        $clearbitUrl = "https://logo.clearbit.com/$formattedName.com";

        // Vérifier si l'image existe
        $headers = @get_headers($clearbitUrl);
        if ($headers && strpos($headers[0], '200')) {
            return $clearbitUrl;
        }

        // Si aucun logo n'est trouvé, utiliser une image par défaut
        return "src/Views/img/uploads/default.png";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Entreprise</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>
<header class="navbar">
    <section class="contenu-nav">
        <div class="gauche">
            <a href="index.php?module=entreprises&action=index">
                <label>
                    <img class="logo" src="src/Views/img/logo.png" alt="logo_img"/>
                </label>
            </a>
        </div>
        <div class="milieu">
            <ul>
                <li><a href="index.php?module=entreprises&action=index">Entreprises</a></li>
                <li><a href="index.php?module=offres&action=index">Offres</a></li>
                <li><a href="index.php?module=Contact&action=index">Contact</a></li>
                <li><button id="bouton-projets">Menu</button></li>
            </ul>
            <div id="icons"></div>
            <div class="droite">
                <?php if (isset($_SESSION['user']) && $_SESSION['user']['id_role'] != 4): ?>
                    <a href="index.php?module=profil&action=index">
                        <label>
                            <img class="profil profil-img" src="src/Views/img/profil.png" alt="photo_de_profil" />
                        </label>
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <section class="navplus">
        <div class="contenu-navplus">
            <ul>
                <?php
                if (isset($_SESSION['user']) && ($_SESSION['user']['id_role'] == 1 || $_SESSION['user']['id_role'] == 3)): ?>
                    <li><a href="index.php?module=Statistiques&action=index">Dashboard</a></li>
                <?php endif; ?>

                <?php
                // Afficher la Wishlist et Mes stages pour tous les utilisateurs sauf ceux avec id_role 4
                if (isset($_SESSION['user']) && $_SESSION['user']['id_role'] != 4): ?>
                    <li><a href="index.php?module=wishlist&action=index">Wishlist</a></li>
                    <li><a href="index.php?module=stages&action=index">Mes stages</a></li>
                <?php endif; ?>

                <li>
                    <?php if (isset($_SESSION["user"])): ?>
                        <form action="logout.php" method="post">
                            <button type="submit" class="bouton-deconnexion">Déconnexion</button>
                        </form>
                    <?php else: ?>
                        <a href="index.php?module=login&action=index">Se connecter</a>
                    <?php endif; ?>
                </li>
            </ul>
        </div>
    </section>
</header>

<div>
    <div>
        <div class="titre-entreprise">Entreprises</div>
        <p class="texte-entreprise">Vous retrouverez ci-dessous toutes les entreprises proposant des stages sur notre site.</p>
    </div>
</div>

<form action="index.php" method="get" class="text-center">
    <input type="hidden" name="module" value="entreprises">
    <input type="hidden" name="action" value="recherche">
    <div>
        <input class="recherche" type="search" name="terme" placeholder="Rechercher une entreprise"
               value="<?= isset($terme) ? htmlspecialchars($terme) : '' ?>">
        <input class="recherche-bouton" type="submit" value="Rechercher">
    </div>
</form>

<!-- Affichage des résultats de recherche -->
<?php if (isset($_GET['terme']) && !empty($_GET['terme'])): ?>
    <div class="search-results-container">
        <h3 class="search-title">Résultats de recherche pour "<?php echo htmlspecialchars($_GET['terme']); ?>"</h3>

        <?php if (isset($entreprisesAffichees) && !empty($entreprisesAffichees)): ?>
            <div class="search-results-grid">
                <?php foreach ($entreprisesAffichees as $e): ?>
                    <div class="search-result-card">
                        <div class="search-result-header">
                            <img src="<?= getLogoUrl($e['nom_entreprise']) ?>" alt="<?= htmlspecialchars($e['nom_entreprise']) ?> - Logo" class="search-result-logo">
                            <h4 class="search-result-title"><?= htmlspecialchars($e['nom_entreprise']) ?></h4>
                        </div>
                        <p class="search-result-info"><strong>Secteur :</strong> <?= htmlspecialchars($e['id_secteur']) ?></p>

                        <div class="search-result-rating">
                            <?php
                            // Récupérer la note moyenne de la base de données (note sur 20)
                            $noteSur20 = isset($e['moyenne_note']) ? (float)$e['moyenne_note'] : 0;

                            // Calculer la note sur 5
                            $noteSur5 = $noteSur20 / 4;

                            // Calculer le nombre d'étoiles pleines, demi et vides
                            $notePleine = floor($noteSur5); // Nombre d'étoiles pleines
                            $noteDemi = ($noteSur5 - $notePleine) >= 0.5 ? 1 : 0; // Vérifie s'il faut une demi-étoile
                            $noteVide = 5 - ($notePleine + $noteDemi); // Complète à 5 étoiles

                            // Afficher les étoiles pleines
                            for ($i = 0; $i < $notePleine; $i++): ?>
                                <img class="etoile" src="src/Views/img/etoile.png" alt="Étoile pleine">
                            <?php endfor;

                            // Afficher une demi-étoile si nécessaire
                            if ($noteDemi): ?>
                                <img class="etoile" src="src/Views/img/etoile-demi.png" alt="Étoile demi-remplie">
                            <?php endif;

                            // Afficher les étoiles vides pour compléter à 5
                            for ($i = 0; $i < $noteVide; $i++): ?>
                                <img class="etoile" src="src/Views/img/etoile-vide.png" alt="Étoile vide">
                            <?php endfor; ?>
                        </div>

                        <div class="search-result-footer">
                            <a href="index.php?module=entreprises&action=show&id=<?= $e['id_entreprise'] ?>" class="btn btn-primary search-button">Voir Plus</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p class="no-results">Aucune entreprise ne correspond à votre recherche.</p>
        <?php endif; ?>
    </div>
<?php else: ?>
    <?php if (isset($entreprisesAffichees) && is_array($entreprisesAffichees) && count($entreprisesAffichees) > 0): ?>
        <div class="container-entreprise">
            <?php foreach ($entreprisesAffichees as $e): ?>
                <div class="entreprise">
                    <!-- Lien vers les détails de l'entreprise -->
                    <a href="index.php?module=entreprises&action=show&id=<?= $e['id_entreprise'] ?>">
                        <img src="<?= getLogoUrl($e['nom_entreprise']) ?>" alt="<?= htmlspecialchars($e['nom_entreprise']) ?> - Logo de l'entreprise" class="card-img-top">
                        <h5><?= htmlspecialchars($e['nom_entreprise']) ?></h5>
                    </a>
                    <p><strong>Secteur :</strong> <?= htmlspecialchars($e['id_secteur']) ?></p>
                    <div style="margin: 10px 0;">
                        <?php
                        // Récupérer la note moyenne de la base de données (note sur 20)
                        $noteSur20 = isset($e['moyenne_note']) ? (float)$e['moyenne_note'] : 0;

                        // Calculer la note sur 5
                        $noteSur5 = $noteSur20 / 4;

                        // Calculer le nombre d'étoiles pleines, demi et vides
                        $notePleine = floor($noteSur5); // Nombre d'étoiles pleines
                        $noteDemi = ($noteSur5 - $notePleine) >= 0.5 ? 1 : 0; // Vérifie s'il faut une demi-étoile
                        $noteVide = 5 - ($notePleine + $noteDemi); // Complète à 5 étoiles

                        // Afficher les étoiles pleines
                        for ($i = 0; $i < $notePleine; $i++): ?>
                            <img class="etoile" src="src/Views/img/etoile.png" alt="Étoile pleine">
                        <?php endfor;

                        // Afficher une demi-étoile si nécessaire
                        if ($noteDemi): ?>
                            <img class="etoile" src="src/Views/img/etoile-demi.png" alt="Étoile demi-remplie">
                        <?php endif;

                        // Afficher les étoiles vides pour compléter à 5
                        for ($i = 0; $i < $noteVide; $i++): ?>
                            <img class="etoile" src="src/Views/img/etoile-vide.png" alt="Étoile vide">
                        <?php endfor; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="container-pagination">
            <div class="container-pagination-precedente">
                <?php if (isset($pageActuelle) && isset($totalPages)): ?>
                <?php if ($pageActuelle > 1): ?>
                    <a href="index.php?module=entreprises&action=index&page=<?= $pageActuelle - 1 ?>" class="pagination-entreprise-precedente">Précédent</a>
                <?php endif; ?>
            </div>

            <div class="container-pagination-suivante">
                <?php if ($pageActuelle < $totalPages): ?>
                    <a href="index.php?module=entreprises&action=index&page=<?= $pageActuelle + 1 ?>" class="pagination-entreprise-suivante">Suivant</a>
                <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>
<?php endif; ?>

<style>
    .search-results-container {
        max-width: 1200px;
        margin: 2rem auto;
        padding: 0 1rem;
    }

    .search-title {
        color: #333;
        font-size: 1.5rem;
        margin-bottom: 1.5rem;
        text-align: center;
        position: relative;
    }

    .search-title:after {
        content: '';
        display: block;
        width: 50px;
        height: 3px;
        background-color: #2196F3;
        margin: 0.5rem auto;
    }

    .search-results-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 1.5rem;
    }

    .search-result-card {
        background-color: white;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        padding: 1.5rem;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        display: flex;
        flex-direction: column;
        height: 100%;
    }

    .search-result-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
    }

    .search-result-header {
        display: flex;
        align-items: center;
        margin-bottom: 1rem;
    }

    .search-result-logo {
        width: 60px;
        height: 60px;
        object-fit: contain;
        margin-right: 1rem;
        border-radius: 4px;
    }

    .search-result-title {
        color: #1976D2;
        font-size: 1.2rem;
        margin: 0;
    }

    .search-result-info {
        color: #666;
        margin-bottom: 1rem;
    }

    .search-result-rating {
        display: flex;
        margin-bottom: 1.5rem;
    }

    .search-result-rating .etoile {
        width: 20px;
        height: 20px;
        margin-right: 2px;
    }

    .search-result-footer {
        margin-top: auto;
        display: flex;
        justify-content: flex-end;
    }

    .search-button {
        background-color: #2196F3;
        color: white;
        border: none;
        border-radius: 4px;
        padding: 0.5rem 1rem;
        font-weight: 500;
        text-decoration: none;
        transition: background-color 0.3s ease;
    }

    .search-button:hover {
        background-color: #1976D2;
    }

    .no-results {
        text-align: center;
        color: #f44336;
        font-size: 1.1rem;
        padding: 2rem;
        background-color: rgba(244, 67, 54, 0.05);
        border-radius: 8px;
        border-left: 4px solid #f44336;
    }

    @media (max-width: 768px) {
        .search-results-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<footer class="text-center" id="footer">
    <div class="container">
        <ul class="list-inline">
            <li class="list-inline-item me-4"><a class="link-secondary" href="index.php?module=conditions&action=index">Conditions générales</a></li>
        </ul><br>
    </div>
    <div class="wrapper">
        <div class="button-footer" id="button-footer-facebook">
            <div class="icon">
                <a href="https://www.facebook.com/profile.php?id=61557360210487" aria-label="Lien vers notre page Facebook"><i class="fab fa-facebook-f"></i></a>
            </div>
            <a href="https://www.facebook.com/profile.php?id=61557360210487">Visitez notre page Facebook</a>
        </div>
        <div class="button-footer" id="button-footer-twitter">
            <div class="icon">
                <a href="https://twitter.com/Cesi_Ton_Stage" aria-label="Lien vers notre compte Twitter"><i class="fab fa-twitter"></i></a>
            </div>
            <a href="https://twitter.com/Cesi_Ton_Stage">Suivez-nous sur Twitter</a>
        </div>
        <div class="button-footer" id="button-footer-instagram">
            <div class="icon">
                <a href="https://www.instagram.com/cesi_ton_stage/" aria-label="Lien vers notre compte Instagram"><i class="fab fa-instagram"></i></a>
            </div>
            <a href="https://www.instagram.com/cesi_ton_stage/">Découvrez-nous sur Instagram</a>
        </div>
    </div>
    <br><br><p class="texte-footer-bottom">Copyright © 2025 CESI TON STAGE</p>
</footer>
<script src="src/Views/js/script.js"></script>
</body>
</html>