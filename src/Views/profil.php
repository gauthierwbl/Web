<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script>
        function toggleEditMode() {
            const viewMode = document.getElementById('view-mode');
            const editMode = document.getElementById('edit-mode');
            const editButton = document.getElementById('edit-button');
            const saveButton = document.getElementById('save-button');

            if (viewMode.style.display !== 'none') {
                viewMode.style.display = 'none';
                editMode.style.display = 'block';
                editButton.style.display = 'none';
                saveButton.style.display = 'inline-block';
            } else {
                viewMode.style.display = 'block';
                editMode.style.display = 'none';
                editButton.style.display = 'inline-block';
                saveButton.style.display = 'none';
            }
        }
    </script>
</head>
<body>
<header class="navbar">
    <section class="contenu-nav">
        <div class="gauche">
            <a href="index.php?module=entreprises&action=index">
                <label>
                <img class="logo" src="http://static.cesitonstage.fr/logo.png" alt="logo_img"/>
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
        <?php 
        
        if ($_SESSION['user']['id_role'] == 1 || $_SESSION['user']['id_role'] == 2): ?>
    <li><a href="index.php?module=Statistiques&action=index">Dashboard</a></li>
<?php endif; ?>
            <li><a href="index.php?module=wishlist&action=index">Wishlist</a></li>
            <li><a href="index.php?module=Stages&action=index">Mes stages</a></li>

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

<!-- Affichage des messages de succès ou d'erreur -->
<?php if (isset($_SESSION['success'])): ?>
    <div class="alert success">
        <?php echo htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?>
    </div>
<?php endif; ?>

<?php if (isset($_SESSION['error'])): ?>
    <div class="alert error">
        <?php echo htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?>
    </div>
<?php endif; ?>

<div class="profil-detail">
    <img class="image-profil" src="<?php echo htmlspecialchars($profilePhoto); ?>" alt="Photo de profil">
    <div class="texte-box-profil">
        <br>
        <h4>Mon Profil : <?php echo htmlspecialchars($login); ?></h4>
    </div>
</div>

<div class="statistiques-profil">
    <h4 class="texte-profil">Statistiques du compte</h4>
    <br>
    <p class="informations-profil">Nombre d'offres dans la wishlist : <?php echo htmlspecialchars($wishlistCount); ?></p>
    <br>
    <p class="informations-profil">Nombre de stages complétés : <?php echo htmlspecialchars($completedInternshipsCount); ?></p>
    <br>
    <p class="informations-profil">Nombre de candidatures envoyées : <?php echo htmlspecialchars($applicationsCount); ?></p>
    <br>
</div>

<div class="offer">
    <h2 class="titre-offre">Mes informations</h2>

    <!-- Mode visualisation -->
    <div id="view-mode" class="info-details">
        <div class="info">
            <h3>Identité : </h3>
            <h4>Prénom : <?php echo htmlspecialchars($identiteData['prenom']); ?></h4>
            <h4>Nom : <?php echo htmlspecialchars($identiteData['nom']); ?> </h4>
        </div>
        <div class="info">
            <h3>Adresse : </h3>
            <h4>Voie postal : <?= htmlspecialchars($adresseData['adresse']) ?></h4>
            <h4>Code Postal : <?= htmlspecialchars($adresseData['zipcode']) ?></h4>
            <h4>Ville : <?= htmlspecialchars($adresseData['nom_ville']) ?> </h4>
        </div>
        <div class="info">
            <h3>Campus : </h3>
            <h4>Nom : <?= htmlspecialchars($campusData['nom_campus']) ?></h4>
            <h4>Promotion : <?= htmlspecialchars($campusData['promotions']) ?> </h4>
            <h4>Mineure : <?= htmlspecialchars($campusData['nom_mineure']) ?></h4>
        </div>
        <div class="info">
            <h3>Photo de profil :</h3>
            <form action="" method="POST" enctype="multipart/form-data" id="photoForm">
                <div class="info-upload">
                    <input class="input-file" type="file" name="fileToUpload" id="fileToUpload" onchange="document.getElementById('photoForm').submit();">
                    <label for="fileToUpload" class="label-file">Choisir un fichier</label>
                </div>
            </form>
            <button id="edit-button" class="recherche-bouton" onclick="toggleEditMode()">Modifier mes informations</button>
        </div>
    </div>

    <!-- Mode édition -->
    <div id="edit-mode" class="info-details" style="display: none;">
        <form action="" method="POST">
            <input type="hidden" name="update_profile" value="1">

            <div class="info">
                <h3>Identité : </h3>
                <div class="form-group">
                    <label for="prenom">Prénom :</label>
                    <input type="text" id="prenom" name="prenom" value="<?php echo htmlspecialchars($identiteData['prenom']); ?>">
                </div>
                <div class="form-group">
                    <label for="nom">Nom :</label>
                    <input type="text" id="nom" name="nom" value="<?php echo htmlspecialchars($identiteData['nom']); ?>">
                </div>
            </div>

            <div class="info">
                <h3>Adresse : </h3>
                <div class="form-group">
                    <label for="adresse">Voie postal :</label>
                    <input type="text" id="adresse" name="adresse" value="<?= htmlspecialchars($adresseData['adresse']) ?>">
                </div>
                <div class="form-group">
                    <label for="zipcode">Code Postal :</label>
                    <input type="text" id="zipcode" name="zipcode" value="<?= htmlspecialchars($adresseData['zipcode']) ?>">
                </div>
                <div class="form-group">
                    <label for="ville">Ville :</label>
                    <input type="text" id="ville" name="ville" value="<?= htmlspecialchars($adresseData['nom_ville']) ?>">
                </div>
            </div>

            <div class="info">
                <h3>Campus : </h3>
                <div class="form-group">
                    <label for="campus">Nom :</label>
                    <input type="text" id="campus" name="campus" value="<?= htmlspecialchars($campusData['nom_campus']) ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="promotion">Promotion :</label>
                    <input type="text" id="promotion" name="promotion" value="<?= htmlspecialchars($campusData['promotions']) ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="mineure">Mineure :</label>
                    <input type="text" id="mineure" name="mineure" value="<?= htmlspecialchars($campusData['nom_mineure']) ?>" readonly>
                </div>
            </div>

            <div class="info">
                <button id="save-button" type="submit" class="recherche-bouton">Enregistrer</button>
                <button type="button" class="recherche-bouton recherche-bouton-cancel" onclick="toggleEditMode()">Annuler</button>
            </div>
        </form>
    </div>
</div>

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