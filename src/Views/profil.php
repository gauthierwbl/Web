
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil</title>
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

<div class="profil-detail">
    <img class="image-profil" src="img/profil.png" alt="Photo de profil">
    <div class="texte-box-profil">
        <br>
        <h4>Mon Profil : <?php echo htmlspecialchars($login); ?></h4>
    </div>
</div>

<div class="statistiques-profil">
    <h4 class="texte-profil">Statistiques du compte</h4>
    <br>
    <p class="informations-profil">Nombre d'offres dans la wishlist : </p>
    <br>
    <p class="informations-profil">Nombre de stages complétés :</p>
    <br>
    <p class="informations-profil">Nombre de candidatures envoyées :</p>
    <br>
</div>
<div class="offer">
    <h2 class="titre-offre">Mes informations</h2>
    <div class="info-details">
        <div class="info">
            <h3>Identité : </h3>
            <h4>Prénom : <?php echo htmlspecialchars($identiteData['prenom']); ?></h4>
            <h4>Nom :<?php echo htmlspecialchars($identiteData['nom']); ?> </h4>
        </div>
        <div class="info">
            <h3>Adresse :  </h3>
            <h4>Voie postal : <?= htmlspecialchars($adresseData['adresse']) ?></h4>
            <h4>Code Postal : Code Postal: <?= htmlspecialchars($adresseData['zipcode']) ?></h4>
            <h4>Ville : <?= htmlspecialchars($adresseData['nom_ville']) ?> </h4>
        </div>
        <div class="info">
            <h3>Campus : </h3>
            <h4>Nom : <?= htmlspecialchars($campusData['nom_campus']) ?></h4>
            <h4>Promotion :<?= htmlspecialchars($campusData['promotions']) ?> </h4>
            <h4>Mineure :<?= htmlspecialchars($campusData['nom_mineure']) ?></h4>
        </div>
        <div class="info">
            <h3>Photo de profil :</h3>
            <form action="" method="POST" enctype="multipart/form-data">
                <div class="info-upload">
                    <label for="formFile" class="form-label">Photo à upload:</label>
                    <br><br>
                    <input class="input-file" type="file" name="fileToUpload" id="fileToUpload">
                    <label for="fileToUpload" class="label-file">Choisir un fichier</label>

                    <button class="recherche-bouton">Modifier</button>
                </div>
            </form>
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
</html>