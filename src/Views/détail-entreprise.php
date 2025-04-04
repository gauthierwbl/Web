<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détail Entreprise</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>
<header class="navbar">
    <section class="contenu-nav">
        <div class="gauche">
            <a href="index.php?module=entreprises&action=index">
            <img class="logo" src="http://static.cesitonstage.fr/logo.png" alt="logo_img"/>
            </a>
        </div>
        <div class="milieu">
            <ul>
                <li><a href="index.php?module=entreprises&action=index">Entreprises</a></li>
                <li><a href="index.php?module=offres&action=index">Offres</a></li>
                <li><a href="src/views/contact.php">Contact</a></li>
                <li><button id="bouton-projets">Menu</button></li>
            </ul>
            <div id="icons"></div>
            <div class="droite">
                <a href="index.php?module=profil&action=index">
                    <img class="profil profil-img" src="index.php?module=profil&action=index" alt="Photo de profil"/>
                </a>
            </div>
        </div>
    </section>
    <nav class="navplus">
        <ul>
        <?php 
        
        if ($_SESSION['user']['id_role'] == 1 || $_SESSION['user']['id_role'] == 3): ?>
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
    </nav>
</header>

<main class="entreprise-detail">
    <img class="image-entreprise" src="<?= getLogoUrl($entreprise['nom_entreprise']) ?>" alt="Logo de l'entreprise">
    <h4 class="en-tete-entreprise"><?= htmlspecialchars($entreprise['nom_entreprise']) ?></h4>
</main>

<section class="statistiques-profil">
    <h4 class="texte-entreprise">Statistiques de l'entreprise</h4>
    <p class="informations-entreprise-detail"><strong>Secteur d'activité :</strong> <?= htmlspecialchars($secteur['nom_secteur']) ?></p>
    <p class="informations-entreprise-detail"><strong>Promotions concernées :</strong> <?= htmlspecialchars($entreprise['promotion_concernee'] ?? 'Non spécifié') ?></p>
</section>

<section class="offer">
    <h4 class="texte-entreprise">Données de l'entreprise</h4>
    <h3>Adresses</h3>
    <?php if (!empty($entreprise['adresses'])): ?>
        <?php foreach ($entreprise['adresses'] as $adresse): ?>
            <p class="informations-entreprise-detail"><?= htmlspecialchars($adresse['adresse']) ?></p>
        <?php endforeach; ?>
    <?php else: ?>
        <p>Aucune adresse disponible.</p>
    <?php endif; ?>
</section>

<section class="offer">
    <h4 class="texte-entreprise">Offres proposées</h4>
    <?php if (!empty($offres)): ?>
        <?php foreach ($offres as $offre): ?>
            <div class="offer">
                <div>
                    <a class="no-decoration" href="index.php?module=offres&action=details&id=<?= $offre['id_offre'] ?>">
                        <img class="image-offre" src="img/uploads/<?= htmlspecialchars($offre['image'] ?? 'default.png') ?>" alt="Logo de l'offre">
                        <h4 class="texte-offre"><?= htmlspecialchars($offre['nom_offre']) ?></h4>
                    </a>
                </div>
                <div>
                    <p class="description-offre"><?= nl2br(htmlspecialchars($offre['description_offre'])) ?></p>
                    <button class="wishlist like" id="wishlist-<?= $offre['id_offre'] ?>" name="wishlist"></button>
                    <div class="start-offre"></div>
                    <a href="index.php?module=offres&action=show&id=<?= $offre['id_offre'] ?>"><button class="voir-plus-offre">Voir Plus</button></a>
                    <div class="start-offre">
                        <?php
                        // Calculer et afficher les étoiles
                        $noteSur20 = isset($offre['moyenne_note']) ? (float)$offre['moyenne_note'] : 0;
                        $noteSur5 = $noteSur20 / 4;
                        $notePleine = floor($noteSur5);
                        $noteDemi = ($noteSur5 - $notePleine) >= 0.5 ? 1 : 0;
                        $noteVide = 5 - ($notePleine + $noteDemi);
                        
                        for ($i = 0; $i < $notePleine; $i++): ?>
                            <img class="etoile" src="img/etoile.png" alt="Étoile pleine">
                        <?php endfor; ?>

                        <?php if ($noteDemi): ?>
                            <img class="etoile" src="img/etoile-demi.png" alt="Étoile demi-remplie">
                        <?php endif; ?>

                        <?php for ($i = 0; $i < $noteVide; $i++): ?>
                            <img class="etoile" src="img/etoile-vide.png" alt="Étoile vide">
                        <?php endfor; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>Aucune offre disponible pour cette entreprise.</p>
    <?php endif; ?>
</section>

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
