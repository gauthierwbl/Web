<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détail offre - <?= htmlspecialchars($offre['nom_offre']) ?></title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        /* Styles pour le cœur de wishlist */
        .wishlist.like {
            display: inline-block;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 24px;
            text-decoration: none;
            background: none;
            border: none;
            padding: 0;
            margin: 0;
        }

        .wishlist.like .fa-heart {
            color: #ccc;
            transition: color 0.3s ease;
        }

        .wishlist.like.like-active .fa-heart {
            color: #ff4757;
        }

        .wishlist.like:hover .fa-heart {
            transform: scale(1.1);
            color: #ff4757;
        }

        /* Styles pour le bouton de retour */
        .bouton-retour-offre-detail {
            background-color: #6c757d;
            color: white;
            border: none;
            padding: 10px 20px;
            margin-left: 10px;
            border-radius: 5px;
            font-weight: 500;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .bouton-retour-offre-detail:hover {
            background-color: #5a6268;
        }
    </style>
</head>
<body>
<header class="navbar">
    <!-- Navigation -->
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

<div class="container-offre-detail">
    <div class="offre-detail">
        <div class="top-box-offre-detail">
            <img class="logo-offre-detail" src="https://logo.clearbit.com/<?= urlencode($entreprise['nom_entreprise']) ?>.com" onerror="this.src='src/Views/img/usine.png'" alt="Logo de l'entreprise">
            <h4 class="titre-top-box-offre-detail"><?= htmlspecialchars($offre['nom_offre']) ?></h4>

            <div class="coeur-detail">
    <?php if ($_SESSION['user']['id_role'] != 4): ?>
        <a href="index.php?module=wishlist&action=<?= $isInWishlist ? 'delete' : 'add' ?>&id=<?= $offre['id_offre'] ?>&redirect=details"
           class="wishlist like <?= $activeClass ?>"
           title="<?= $isInWishlist ? 'Retirer de la wishlist' : 'Ajouter à la wishlist' ?>">
            <i class="fas fa-heart"></i>
        </a>
    <?php endif; ?>
</div>


            <div class="start-offre-detail">
                <?php
                $noteSur20 = isset($offre['moyenne_note']) ? (float)$offre['moyenne_note'] : 0;
                $noteSur5 = $noteSur20 / 4;
                $notePleine = floor($noteSur5);
                $noteDemi = ($noteSur5 - $notePleine) >= 0.5 ? 1 : 0;
                $noteVide = 5 - ($notePleine + $noteDemi);

                for ($i = 0; $i < $notePleine; $i++): ?>
                    <img class="etoile active" src="src/Views/img/etoile-pleine.png" alt="Étoile pleine">
                <?php endfor;

                if ($noteDemi): ?>
                    <img class="etoile active" src="src/Views/img/etoile-demi.png" alt="Étoile demi-remplie">
                <?php endif;

                for ($i = 0; $i < $noteVide; $i++): ?>
                    <img class="etoile" src="src/Views/img/etoile-vide.png" alt="Étoile vide">
                <?php endfor; ?>
            </div>
        </div>

        <div class="statistiques-offre-detail">
            <p class="description-offre-detail">
                <strong>Entreprise :</strong> <?= htmlspecialchars($entreprise['nom_entreprise']) ?><br>
                <strong>Titre du poste :</strong> <?= htmlspecialchars($offre['nom_offre']) ?><br>
                <strong>Description :</strong><br><?= nl2br(htmlspecialchars($offre['description_offre'])) ?><br>
                <strong>Compétences requises :</strong><br><?= nl2br(htmlspecialchars($offre['competences'])) ?><br>
                <strong>Mineure :</strong> <?= htmlspecialchars($mineure['nom_mineure'] ?? $offre['id_mineure']) ?><br>
                <strong>Durée du stage :</strong> <?= htmlspecialchars($offre['duree_stage']) ?> semaines<br>
                <strong>Rémunération :</strong> <?= htmlspecialchars($offre['base_remuneration']) ?> €<br>
                <strong>Places disponibles :</strong> <?= htmlspecialchars($offre['nombre_place']) ?><br>
                <strong>Nombre de candidatures :</strong> <?= htmlspecialchars($offre['nombre_candidature']) ?>
            </p>
        </div>

        <div class="bottom-box-offre-detail">
    <?php if ($_SESSION['user']['id_role'] != 4): ?>
        <a href="index.php?module=Traitement&action=index&id=<?= $offre['id_offre'] ?>">
            <button class="bouton-postuler-offre-detail">Postuler</button>
        </a>
    <?php endif; ?>
    <a href="index.php?module=offres&action=index">
        <button class="bouton-retour-offre-detail">Retour aux offres</button>
    </a>
</div>

    </div>
</div>

<footer class="text-center" id="footer">
    <div class="container">
        <ul class="list-inline">
            <li class="list-inline-item me-4"><a class="link-secondary" href="/condition">Conditions générales</a></li>
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
