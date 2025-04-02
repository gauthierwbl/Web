<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ma Wishlist</title>
    <link rel="stylesheet" href="css/styles.css">
</head>

    <header class="navbar">
        <section class="contenu-nav">
            <div class="gauche">
                <a href="/">
                    <img class="logo" src="src/Views/img/logo.png" alt="logo_img"/>
                </a>
            </div>
            <div class="milieu">
                <ul>
                    <li><a href="index.php?module=entreprises&action=index">Entreprises</a></li>
                    <li><a href="index.php?module=offres&action=index">Offres</a></li>
                    <li><a href="index.php?module=wishlist&action=index">Wishlist</a></li>
                </ul>
            </div>
            <div class="droite">
                <a href="/profile">
                    <img class="profil profil-img" src="src/Views/img/profil.png" alt="photo_de_profile"/>
                </a>
            </div>
        </section>
    </header>

    <div class="titre-entreprise">Ma Wishlist</div>
    <p class="texte-entreprise">Voici les offres que vous avez enregistrées.</p>

    <main class="container-entreprise">
        <section class="offres">
            <?php if (!empty($offres)): ?>
                <?php foreach ($offres as $offre): ?>
                    <div class="offer">
                        <div class="offre-header">
                            <img src="https://logo.clearbit.com/<?= urlencode($offre['nom_entreprise']) ?>.com" class="image-offre" onerror="this.src='src/Views/img/profil.png'">
                            <h2 class="texte-offre"><?= htmlspecialchars($offre['nom_offre']) ?></h2>
                        </div>
                        <p class="description-offre">
                            <strong>Entreprise :</strong> <?= htmlspecialchars($offre['nom_entreprise']) ?><br>
                            <strong>Description :</strong> <?= nl2br(htmlspecialchars(mb_strimwidth($offre['description_offre'], 0, 100, '...'))) ?><br>
                            <strong>Mineure :</strong> <?= htmlspecialchars($offre['id_mineure']) ?>
                        </p>
                        <div class="offre-footer">
                            <!-- Cœur pour retirer de la wishlist -->
                            <a class="wishlist like like-active"
                               href="index.php?module=wishlist&action=delete&id=<?= $offre['id_offre'] ?>"
                               title="Retirer de la wishlist"
                               onclick="return confirm('Retirer cette offre de votre liste ?');">
                                <i class="fas fa-heart"></i>
                            </a>

                            <!-- Voir plus -->
                            <a class="voir-plus-offre" href="index.php?module=offres&action=edit&id=<?= $offre['id_offre'] ?>">Voir Plus</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p style="color: red;">Vous n'avez aucune offre dans votre wishlist.</p>
            <?php endif; ?>
        </section>
    </main>

<!-- Pagination -->
<div class="container-pagination">
    <div class="container-pagination-precedente">
        <?php if (isset($pageActuelle) && isset($totalPages)): ?>
            <?php if ($pageActuelle > 1): ?>
                <a href="index.php?module=wishlist&action=index&page=<?= $pageActuelle - 1 ?>" class="pagination-entreprise-precedente">Précédent</a>
            <?php endif; ?>
        <?php endif; ?>
    </div>
    <div class="container-pagination-suivante">
        <?php if ($pageActuelle < $totalPages): ?>
            <a href="index.php?module=wishlist&action=index&page=<?= $pageActuelle + 1 ?>" class="pagination-entreprise-suivante">Suivant</a>
        <?php endif; ?>
    </div>
</div>



    <!-- Footer -->
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
