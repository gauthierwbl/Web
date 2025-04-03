<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Entreprise</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>

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

<div>
    <div>
        <div class="titre-entreprise">Entreprises</div>
        <p class="texte-entreprise">Vous retrouverez ci-dessous toutes les entreprises proposant des stages sur notre site.</p>
    </div>
</div>

<form action="index.php?module=entreprises&action=index" method="get" class="text-center">
    <div>
        <input class="recherche" type="search" name="terme">
        <input class="recherche-bouton" type="submit" name="submit" value="Rechercher">
    </div>
</form>

<?php
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

if (isset($entreprisesAffichees) && is_array($entreprisesAffichees) && count($entreprisesAffichees) > 0): ?>
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
<?php else: ?>
    <p style="color: red;">Aucune entreprise trouvée.</p>
<?php endif; ?>


<div class="container-pagination">
    <div class="container-pagination-precedente">
        <?php if (isset($pageActuelle) && isset($totalPages)): ?>
        <?php if ($pageActuelle > 1): ?>
            <a href="index.php?module=entreprises&action=index&page=<?= $pageActuelle - 1 ?>" class="pagination-entreprise-precedente" >Précédent</a>
        <?php endif; ?>
    </div>

    <div class="container-pagination-suivante">
        <?php if ($pageActuelle < $totalPages): ?>
            <a href="index.php?module=entreprises&action=index&page=<?= $pageActuelle + 1 ?>" class="pagination-entreprise-suivante" > Suivant</a>
        <?php endif; ?>
        <?php endif; ?>
    </div>
</div>

<footer class="text-center" id="footer">
    <div class="container">
        <ul class="list-inline">
            <li class="list-inline-item me-4"><a class="link-secondary" href="condition-general.php">Conditions générales</a></li>
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
