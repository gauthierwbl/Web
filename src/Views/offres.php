<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Offres de stage - Pagination</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        /* Styles pour les cœurs de wishlist */
        .wishlist {
            display: inline-block;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            background: none;
            border: none;
            padding: 0;
        }

        .wishlist .fa-heart {
            color: #ccc;
            transition: color 0.3s ease;
            font-size: 18px;
        }

        .wishlist.like-active .fa-heart {
            color: #ff4757;
        }

        .wishlist:hover .fa-heart {
            transform: scale(1.1);
            color: #ff4757;
        }
        /* CSS pour positionner le cœur au milieu à droite de chaque offre */

        /* S'assurer que l'offre a une position relative pour le positionnement absolu du cœur */
        .offer {
            position: relative;
        }

        /* Positionnement du cœur au milieu à droite */
        .wishlist {
            position: absolute;
            top: 50%; /* Centrer verticalement */
            right: 15px;
            transform: translateY(-50%); /* Ajustement pour centrer parfaitement */
            z-index: 10;
        }

        /* Augmenter la taille du cœur pour qu'il soit bien visible */
        .wishlist .fa-heart {
            font-size: 24px;
        }

        /* Couleurs du cœur */
        .wishlist .fa-heart {
            color: #ccc;
            transition: color 0.3s ease, transform 0.3s ease;
        }

        .wishlist.like-active .fa-heart {
            color: #ff4757;
        }

        .wishlist:hover .fa-heart {
            transform: scale(1.1);
            color: #ff4757;
        }
    </style>
</head>
<body>
<header class="navbar">
    <section class="contenu-nav">
        <div class="gauche">
            <a href="index.php?module=entreprises&action=index">
                <label>
                <img class="logo" src="http://static.cesitonstage.fr/logo.png" alt="logo_img"/>
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

            <?php if ($_SESSION['user']['id_role'] != 4): ?>
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
        
        if ($_SESSION['user']['id_role'] == 1 || $_SESSION['user']['id_role'] == 2): ?>
    <li><a href="index.php?module=Statistiques&action=index">Dashboard</a></li>
<?php endif; ?>

<?php 
// Afficher la Wishlist et Mes stages pour tous les utilisateurs sauf ceux avec id_role 4
if ($_SESSION['user']['id_role'] != 4): ?>
    <li><a href="index.php?module=wishlist&action=index">Wishlist</a></li>
    <li><a href="index.php?module=Stages&action=index">Mes stages</a></li>
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

<!-- Affichage des messages de succès ou d'erreur -->
<?php if (isset($_SESSION['success'])): ?>
    <div class="alert success">
        <?php echo htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?>
    </div>
<?php endif; ?>

<?php if (isset($_SESSION['error'])): ?>
    <div class="alert error">
        <?php echo htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?>
    </div>
<?php endif; ?>

<div>
    <div>
        <div class="titre-entreprise">Offres</div>
        <p class="texte-entreprise">Vous retrouverez ci-dessous toutes offres de Stage.</p>
    </div>
</div>

<form action="index.php?module=offres&action=recherche" method="get" class="text-center">
    <input type="hidden" name="module" value="offres">
    <input type="hidden" name="action" value="recherche">
    <div>
        <input class="recherche" type="search" name="terme" placeholder="Rechercher une offre">
        <input class="recherche-bouton" type="submit" name="submit" value="Rechercher">
    </div>
</form>




<!-- Affichage des résultats de recherche -->
<?php if (isset($_GET['terme']) && !empty($_GET['terme'])): ?>
    <div class="search-results-container">
        <h3 class="search-title">Résultats de recherche pour "<?php echo htmlspecialchars($_GET['terme']); ?>"</h3>
        
        <?php if (isset($offres) && !empty($offres)): ?>
            <div class="search-results-grid">
                <?php foreach ($offres as $offre): ?>
                    <div class="search-result-card">
                        <h4 class="search-result-title"><?php echo htmlspecialchars($offre['nom_offre']); ?></h4>
                        <p class="search-result-description">
                            <?php echo nl2br(htmlspecialchars(mb_strimwidth($offre['description_offre'] ?? '', 0, 100, '...'))); ?>
                        </p>
                        <div class="search-result-footer">
                            <a href="index.php?module=offres&action=details&id=<?php echo $offre['id_offre']; ?>" class="btn btn-primary search-button">Voir Plus</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p class="no-results">Aucune offre ne correspond à votre recherche.</p>
        <?php endif; ?>
    </div>
<?php endif; ?>

<!-- Ajoutez ce CSS dans votre fichier styles.css ou dans une section style dans offres.php -->
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
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
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

    .search-result-title {
        color: #1976D2;
        font-size: 1.2rem;
        margin-top: 0;
        margin-bottom: 1rem;
    }

    .search-result-description {
        color: #666;
        flex-grow: 1;
        margin-bottom: 1.5rem;
        line-height: 1.5;
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

<main class="container-entreprise">
    <section class="offres">
        <?php if (isset($offresAffichees) && is_array($offresAffichees) && count($offresAffichees) > 0): ?>
            <?php foreach ($offresAffichees as $offre): ?>
                <div class="offer">
                    <div class="offre-header">
                        <!-- Affichage dynamique du logo de l'entreprise -->
                        <img src="https://logo.clearbit.com/<?= urlencode($offre['nom_entreprise']) ?>.com" class="image-offre" onerror="this.src='src/Views/img/usine.png'">
                        <h2 class="texte-offre"><?= htmlspecialchars($offre['nom_offre']) ?></h2>
                    </div>
                    <p class="description-offre">
                        <strong>Entreprise :</strong> <?= htmlspecialchars($offre['nom_entreprise']) ?><br>
                        <strong>Titre du poste :</strong> <?= htmlspecialchars($offre['nom_offre']) ?><br>
                        <strong>Description :</strong>
                        <?= nl2br(htmlspecialchars(mb_strimwidth($offre['description_offre'], 0, 100, '...'))) ?><br>
                        <strong>ID Mineure :</strong> <?= htmlspecialchars($offre['id_mineure']) ?>
                    </p>
                    <div class="offre-footer">
                        <div class="start-offre">
                            <?php
                            // Récupérer la note moyenne de la base de données (note sur 20)
                            $noteSur20 = isset($offre['moyenne_note']) ? (float)$offre['moyenne_note'] : 0;

                            // Calculer la note sur 5
                            $noteSur5 = $noteSur20 / 4;

                            // Calculer le nombre d'étoiles pleines, demi et vides
                            $notePleine = floor($noteSur5); // Nombre d'étoiles pleines
                            $noteDemi = ($noteSur5 - $notePleine) >= 0.5 ? 1 : 0; // Vérifie s'il faut une demi-étoile
                            $noteVide = 5 - ($notePleine + $noteDemi); // Complète à 5 étoiles

                            // Afficher les étoiles pleines
                            for ($i = 0; $i < $notePleine; $i++): ?>
                                <img class="etoile active" src="src/Views/img/etoile-pleine.png" alt="Étoile pleine">
                            <?php endfor;

                            // Afficher une demi-étoile si nécessaire
                            if ($noteDemi): ?>
                                <img class="etoile active" src="src/Views/img/etoile-demi.png" alt="Étoile demi-remplie">
                            <?php endif;

                            // Afficher les étoiles vides pour compléter à 5
                            for ($i = 0; $i < $noteVide; $i++): ?>
                                <img class="etoile" src="src/Views/img/etoile-vide.png" alt="Étoile vide">
                            <?php endfor; ?>
                        </div>

                        <?php
                        // Vérifier si l'offre est dans la wishlist
                        $isInWishlist = isset($offre['in_wishlist']) ? $offre['in_wishlist'] : false;
                        ?>

                        <!-- Cœur pour la wishlist -->
                        <?php if ($_SESSION['user']['id_role'] != 4): ?>
    <a class="wishlist <?= $isInWishlist ? 'like-active' : '' ?>"
       href="index.php?module=wishlist&action=<?= $isInWishlist ? 'delete' : 'add' ?>&id=<?= $offre['id_offre'] ?>"
       title="<?= $isInWishlist ? 'Retirer de la wishlist' : 'Ajouter à la wishlist' ?>">
        <i class="fas fa-heart"></i>
    </a>
<?php endif; ?>

                        <!-- Lien pour voir les détails de l'offre -->
                        <a href="index.php?module=offres&action=details&id=<?= $offre['id_offre'] ?>" class="btn btn-primary">Voir Plus</a>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </section>
</main>

<div class="container-pagination">
    <div class="container-pagination-precedente">
        <?php if (isset($pageActuelle) && isset($totalPages)): ?>
            <?php if ($pageActuelle > 1): ?>
                <a href="index.php?module=offres&action=index&page=<?= $pageActuelle - 1 ?>" class="pagination-entreprise-precedente">Précédent</a>
            <?php endif; ?>
        <?php endif; ?>
    </div>
    <div class="container-pagination-suivante">
        <?php if ($pageActuelle < $totalPages): ?>
            <a href="index.php?module=offres&action=index&page=<?= $pageActuelle + 1 ?>" class="pagination-entreprise-suivante">Suivant</a>
        <?php endif; ?>
    </div>
</div>

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
</body>
<script src="src/Views/js/script.js"></script>
</html>