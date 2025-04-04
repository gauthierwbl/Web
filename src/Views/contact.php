<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script src="js/script.js"></script>

</head>

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
            <?php if ($_SESSION['user']['id_role'] != 4): ?>
    <a href="profil.php">
        <label>
            <img class="profil profil-img" src="src/Views/img/profil.png" alt="photo_de_profil" />
        </label>
    </a>
<?php endif; ?>

            </div>
        </div>
    </section>
    <section class="navplus">
    <div class="contenu-navplus">
        <ul>
        <?php 
        
        if ($_SESSION['user']['id_role'] == 1 || $_SESSION['user']['id_role'] == 3): ?>
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
    
    <div class="titre-contact">Contactez-nous !</div>
   
<div>
<form action="send_mail.php" method="POST">
    <div class="form-group">
    <div class="texte-contact">Prénom :</div>
      <input type="text" class="formulaire-contact" id="fname" placeholder="Entrez votre prénom" name="fname">
    </div>
    <div class="form-group">
    <div class="texte-contact">Nom de famille :</div>
      <input type="text" class="formulaire-contact" id="lname" placeholder="Entrez votre nom de famille" name="lname">
    </div>
    <div class="form-group">
    <div class="texte-contact">E-mail :</div>
      <input type="email" class="formulaire-contact" id="email" placeholder="Entrez votre email" name="email">
    </div>
    <div class="form-group">
    <div class="texte-contact">Message :</div>
      <textarea class="message-contact" id="message" placeholder="Entrez votre message" name="message"></textarea>
    </div>
    <button type="submit" class="bouton-envoyer-contact">Envoyer</button>
</form>
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
