<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stages Validés - Pagination</title>
    <link rel="stylesheet" href="css/styles.css">
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
                <li><a href="src/views/contact.php">Contact</a></li>
                <li><button id="bouton-projets">Menu</button></li>
            </ul>
            <div id="icons"></div>
            <div class="droite">
                <a href="index.php?module=profil&action=index">
                    <label>
                        <img class="profil profil-img" src="src/Views/img/profil.png" alt="Photo de profil"/>
                    </label>
                </a>
            </div>
        </div>
    </section>
    <section class="navplus">
    <div class="contenu-navplus">
        <ul>
            <li><a href="/">Accueil</a></li>
            <li><a href="index.php?module=Statistiques&action=index">Dashboard</a></li>
            <li><a href="index.php?module=wishlist&action=index">Wishlist</a></li>
            <li><a href="index.php?module=stages&action=index">Mes stages</a></li>
            
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
            <div class="titre-entreprise">Stages Validés</div>
            <p class="texte-entreprise">Vous retrouverez ci-dessous tous les stages validés sur notre plateforme.</p>
        </div>
    </div>

    <!-- Search Bar -->
    <form action="index.php?module=stages&action=index" method="get" class="text-center">
        <div>
            <input class="recherche" type="search" name="terme" placeholder="Rechercher un stage">
            <input class="recherche-bouton" type="submit" name="submit" value="Rechercher">
        </div>
    </form>

    <!-- Stages Container -->
<main class="container-entreprise">
    <section class="offres">
        <?php
        function getLogoUrl($companyName) {
            $formattedName = strtolower(str_replace(' ', '', $companyName));
            $clearbitUrl = "https://logo.clearbit.com/$formattedName.com";
            $headers = @get_headers($clearbitUrl);
            if ($headers && strpos($headers[0], '200')) {
                return $clearbitUrl;
            }
            return "src/Views/img/uploads/default.png";
        }

        if (isset($stagesAffiches) && is_array($stagesAffiches) && count($stagesAffiches) > 0): ?>
            <?php foreach ($stagesAffiches as $stage): ?>
                <div class="offer">
                    <div class="offre-header">
                        <img src="<?= getLogoUrl($stage['nom_entreprise']) ?>" class="image-offre" onerror="this.src='src/Views/img/profil.png'">
                        <h2 class="texte-offre"><?= htmlspecialchars($stage['nom_offre']) ?></h2>
                    </div>
                    <p class="description-offre">
                        <strong>Entreprise :</strong> <?= htmlspecialchars($stage['nom_entreprise']) ?><br>
                        <strong>Nom du stage :</strong> <?= htmlspecialchars($stage['nom_offre']) ?>
                    </p>
                    <div class="offre-footer">
                        <a class="voir-plus-offre" href="http://localhost/Web/src/views/evaluation.php?action=evaluation.php&id=<?= $stage['id_offre'] ?>">Évaluer</a>

                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p style="color: red;">Aucun stage validé trouvé.</p>
        <?php endif; ?>
    </section>
</main>

    <!-- Pagination -->
<div class="container-pagination">
    <div class="container-pagination-precedente">
        <?php if (isset($pageActuelle) && isset($totalPages)): ?>
            <?php if ($pageActuelle > 1): ?>
                <a href="index.php?module=stages&action=index&page=<?= $pageActuelle - 1 ?>" class="pagination-entreprise-precedente">Précédent</a>
            <?php endif; ?>
        <?php endif; ?>
    </div>
    <div class="container-pagination-suivante">
        <?php if ($pageActuelle < $totalPages): ?>
            <a href="index.php?module=stages&action=index&page=<?= $pageActuelle + 1 ?>" class="pagination-entreprise-suivante">Suivant</a>
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
<script src="src/Views/js/script.js"></script>
</html>
