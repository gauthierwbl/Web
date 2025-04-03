<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détail Entreprise</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body style="background-image: url('img/background.png');">
    <header class="navbar">
        <section class="contenu-nav">
            <div class="gauche">
                <a href="index.php?module=entreprises&action=index">
                    <label>
                        <img class="logo" src="img/logo.png" alt="logo_img"/>
                    </label>
                </a>
            </div>
            <div class="milieu">
                <ul>
                    <li><a href="index.php?module=entreprises&action=index">Entreprises</a></li>
                    <li><a href="index.php?module=offres&action=index">Offres</a></li>
                    <li><a href="index.php?module=contact&action=index">Contact</a></li>
                    <li><button id="bouton-projets">Menu</button></li>
                </ul>
                <div id="icons"></div>
                <div class="droite">
                    <a href="index.php?module=profil&action=index">
                        <label>
                            <img class="profil profil-img" src="img/profil.png" alt="photo_de_profile"/>
                        </label>
                    </a>
                </div>
            </div>
        </section>
    </header>
    
    <div class="entreprise-detail">
        <img class="image-entreprise" src="<?= getLogoUrl($entreprise['nom_entreprise']) ?>" alt="Logo de l'entreprise">
        <h4 class="en-tete-entreprise"><?= htmlspecialchars($entreprise['nom_entreprise']) ?></h4>
    </div>
    
    <div class="statistiques-profil">
        <h4 class="texte-entreprise">Statistiques de l'entreprise</h4>          
        <p class="informations-entreprise-detail"><strong>Secteur d'activité :</strong> <?= htmlspecialchars($secteur['nom_secteur']) ?></p>
        <p class="informations-entreprise-detail"><strong>Promotions concernées :</strong> <?= htmlspecialchars($entreprise['promotion_concernee'] ?? 'Non spécifié') ?></p>
    </div>
    
    <div class="offer">
        <h4 class="texte-entreprise">Données de l'entreprise</h4> 
        <h3>Adresses</h3>
        <?php if (!empty($adresses)): ?>
            <?php foreach ($adresses as $adresse): ?>
                <p class="informations-entreprise-detail"><?= htmlspecialchars($adresse['adresse']) ?></p>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Aucune adresse disponible.</p>
        <?php endif; ?>
    </div>

    <div class="offer">
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
                        <a href="index.php?module=offres&action=details&id=<?= $offre['id_offre'] ?>"><button class="voir-plus-offre">Voir Plus</button></a>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Aucune offre disponible pour cette entreprise.</p>
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