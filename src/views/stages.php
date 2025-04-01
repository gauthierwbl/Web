<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stages Validés - Pagination</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body style="background-image: url('src/Views/img/background.png');">

    <!-- Navbar -->
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
    <div class="pagination">
        <?php if (isset($pageActuelle) && isset($totalPages)): ?>
            <?php if ($pageActuelle > 1): ?>
                <a href="index.php?module=Stages&action=index&page=<?= $pageActuelle - 1 ?>">Précédent</a>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <a href="index.php?module=Stages&action=index&page=<?= $i ?>" class="<?= ($i == $pageActuelle) ? 'active' : '' ?>"><?= $i ?></a>
            <?php endfor; ?>

            <?php if ($pageActuelle < $totalPages): ?>
                <a href="index.php?module=Stages&action=index&page=<?= $pageActuelle + 1 ?>">Suivant</a>
            <?php endif; ?>
        <?php endif; ?>
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
