<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Evaluation</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

</head>
<body style="background-image: url('img/background.png');">
    <header class="navbar">
        <section class="contenu-nav">
            <div class="gauche">
                <a href="/">
                    <label>
                        <img class="logo" src="img/logo.png" alt="logo_img"/>
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
                            <img class="profil profil-img" src="img/profil.png" alt="photo_de_profile"/>
                        </label>
                    </a>
                </div>
            </div>
        </section>
    </header>
   
<div class="titre-postuler">Évaluation du stage : </div>
    
    <div class="offer">
        <?php if(isset($_GET['error'])): ?>
            <p class="error-message">Une erreur s'est produite lors de l'enregistrement de votre évaluation.</p>
        <?php endif; ?>
        
        <?php if(isset($_GET['success'])): ?>
            <p class="success-message">Votre évaluation a été enregistrée avec succès !</p>
        <?php endif; ?>
        
        <p>Merci de noter votre expérience de stage sur une échelle de 0 à 20</p>
        
        <form action="evaluation.php?action=evaluation.php" method="post" class="verif">
            <input type="hidden" name="id_utilisateur" value="<?php echo $_SESSION['user_id'] ?? 1; ?>">
            <input type="hidden" name="id_entreprise" value="<?php echo $_GET['id_entreprise'] ?? 1; ?>">
            
            <label for="note">Note globale du stage :</label>
            <input type="number" class="formulaire-contact" name="note" id="note" min="0" max="20" required>
            
            <button type="submit" class="bouton-envoyer-contact">Envoyer</button>   
        </form>
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
