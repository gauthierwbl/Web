<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Entreprise</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body style="background-image: url('src/Views/img/background.png');">
    <header class="navbar">
        <section class="contenu-nav">
            <div class="gauche">
                <a href="home.php">
                    <img class="logo" src="src/Views/img/logo.png" alt="logo_img"/>
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
                    <a href="profil.php">
                        <img class="profil profil-img" src="src/Views/img/profil.png" alt="photo_de_profile"/>
                    </a>
                </div>
            </div>
        </section>
    </header>
    
    <main>
        <div>
            <h1 class="titre-entreprise">Entreprises</h1>
            <p class="texte-entreprise">Vous retrouverez ci-dessous toutes les entreprises proposant des stages sur notre site.</p>
        </div>
        
        <form action="" method="get" class="text-center">
            <div>
                <input class="recherche" type="search" name="terme" placeholder="Rechercher une entreprise...">
                <input class="recherche-bouton" type="submit" name="submit" value="Rechercher">
            </div>
        </form>

        <?php
        function getLogoUrl($companyName) {
            $clearbitUrl = "https://logo.clearbit.com/" . urlencode($companyName) . ".com";

            // Vérifier si l'image existe
            $headers = @get_headers($clearbitUrl);
            if ($headers && strpos($headers[0], '200')) {
                return $clearbitUrl;
            }

            // Si aucun logo n'est trouvé, utiliser une image par défaut
            return "src/Views/img/uploads/default.png";
        }

        if (isset($entreprisesAffichees) && is_array($entreprisesAffichees) && count($entreprisesAffichees) > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Secteur d'activité</th>
                        <th>Ville</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($entreprisesAffichees as $e): ?>
                    <tr>
                        <td><?= htmlspecialchars($e['nom_entreprise']) ?></td>
                        <td><?= htmlspecialchars($e['id_secteur']) ?></td>
                        <td><?= htmlspecialchars($e['id_fichier']) ?></td>
                        <td>
                            <a class="icon-link" href="index.php?module=entreprises&action=edit&id=<?= $e['id_entreprise'] ?>">✏️</a>
                            <a class="icon-link" href="index.php?module=entreprises&action=delete&id=<?= $e['id_entreprise'] ?>" onclick="return confirm('Confirmer la suppression ?');">🗑️</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p style="color: red;">Aucune entreprise trouvée.</p>
        <?php endif; ?>

        <div class="pagination">
            <?php if (isset($pageActuelle) && isset($totalPages)): ?>
                <?php if ($pageActuelle > 1): ?>
                    <a href="index.php?module=entreprises&action=index&page=<?= $pageActuelle - 1 ?>">Précédent</a>
                <?php endif; ?>

                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <a href="index.php?module=entreprises&action=index&page=<?= $i ?>" class="<?= ($i == $pageActuelle) ? 'active' : '' ?>"><?= $i ?></a>
                <?php endfor; ?>

                <?php if ($pageActuelle < $totalPages): ?>
                    <a href="index.php?module=entreprises&action=index&page=<?= $pageActuelle + 1 ?>">Suivant</a>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </main>
    
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
        <br><br>
        <p class="texte-footer-bottom">Copyright © 2025 CESI TON STAGE</p>
    </footer>
</body>
</html>
