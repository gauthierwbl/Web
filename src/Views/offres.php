<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Offres de stage - Pagination</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

</head>

<header class="navbar">
    <section class="contenu-nav">
        <div class="gauche">
            <a href="/">
                <label>
                    <img class="logo" src="src/Views/img/logo.png" alt="logo_img"/>
                </label>
            </a>
        </div>
        <div class="milieu">
            <ul>
                <li><a href="index.php?module=entreprises&action=index">Entreprises</a></li>
                <li><a href="index.php?module=offres&action=index">Offres</a></li>
                <li><a href="/contact">Contact</a></li>
                <li><button id="bouton-projets">Menu</button></li>
            </ul>
            <div id="icons"></div>
            <div class="droite">
                <a href="/profile">
                    <label>
                        <img class="profil profil-img" src="src/Views/img/profil.png" alt="photo_de_profile"/>
                    </label>
                </a>
            </div>
        </div>
    </section>
</header>

<div>
    <div>
        <div class="titre-entreprise">Offres</div>
        <p class="texte-entreprise">Vous retrouverez ci-dessous toutes offres de Stage.</p>
    </div>
</div>

<form action="index.php?module=offres&action=index" method="get" class="text-center">
    <div>
        <input class="recherche" type="search" name="terme" placeholder="Rechercher une offre">
        <input class="recherche-bouton" type="submit" name="submit" value="Rechercher">
    </div>
</form>

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
                        <div>
                            Note : <?= isset($offre['moyenne_note']) && $offre['moyenne_note'] > 0 ?
                                number_format($offre['moyenne_note'], 1) . "/20" : "Non disponible" ?>
                        </div>
                        <a class="wishlist like"
                           href="index.php?module=wishlist&action=add&id=<?= $offre['id_offre'] ?>"
                           title="Ajouter à la wishlist"
                           onclick="return confirm('Ajouter cette offre à votre wishlist ?');">
                        </a>
                        <a class="voir-plus-offre" href="index.php?module=offres&action=edit&id=<?= $offre['id_offre'] ?>">Voir Plus</a>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p style="color: red;">Aucune offre trouvée.</p>
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
</html>
