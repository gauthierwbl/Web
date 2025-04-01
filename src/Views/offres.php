<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Offres de stage - Pagination</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
 
</head>
<body style="background-image: url('src/Views/img/background.png');">
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
                    <li><a href="/entreprise">Entreprises</a></li>
                    <li><a href="/offre">Offres</a></li>
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
                                <img class="etoile active" src="src/Views/img/etoile.png" alt="etoile active">
                                <img class="etoile active" src="src/Views/img/etoile.png" alt="etoile active">
                                <img class="etoile" src="src/Views/img/etoile.png" alt="etoile">
                                <img class="etoile" src="src/Views/img/etoile.png" alt="etoile">
                                <img class="etoile" src="src/Views/img/etoile.png" alt="etoile">
                            </div>
                            <a class="wishlist like" href="#" title="Ajouter aux favoris"></a>
                            <a class="voir-plus-offre" href="index.php?module=offres&action=edit&id=<?= $offre['id_offre'] ?>">Voir Plus</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p style="color: red;">Aucune offre trouvée.</p>
            <?php endif; ?>
        </section>
    </main>




    <div class="pagination">
    <?php if (isset($pageActuelle) && isset($totalPages)): ?>
        <?php if ($pageActuelle > 1): ?>
            <a href="index.php?module=offres&action=index&page=<?= $pageActuelle - 1 ?>">Précédent</a>
        <?php endif; ?>

        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <a href="index.php?module=offres&action=index&page=<?= $i ?>" class="<?= ($i == $pageActuelle) ? 'active' : '' ?>"><?= $i ?></a>
        <?php endfor; ?>

        <?php if ($pageActuelle < $totalPages): ?>
            <a href="index.php?module=offres&action=index&page=<?= $pageActuelle + 1 ?>">Suivant</a>
        <?php endif; ?>
    <?php endif; ?>
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
