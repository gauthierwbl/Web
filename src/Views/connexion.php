<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link rel="stylesheet" href="src/Views/css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
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
        
</section>
</header>
    
    <div class="titres-login">
        <h1>Connectez vous !</h1>
        <p class="texte-login">Pour pouvoir accéder à l'intégralité des fonctionnalités de la plateforme CESI TON STAGE, il est nécessaire de se connecter à son compte</p>
    </div>
    
    <div class="formulaire-login">
        <?php if (isset($error)): ?>
            <div class="error-message" style="color: red; text-align: center; margin-bottom: 15px;">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>
        
        <form class="text-center" method="post" action="index.php?module=auth&action=login">
            <div><input class="formulaire-contact" type="text" name="login" placeholder="Login" required></div>
            <div><input class="formulaire-contact" type="password" name="password" placeholder="Password" required></div>
            <div><button class="recherche-bouton" type="submit" style="background: rgba(52, 152, 219);">Login</button></div>          
        </form>
        
        <div style="text-align: center; margin-top: 15px;">
        <a href="index.php?module=auth&action=guestAccess" class="recherche-bouton" style="background: rgba(52, 152, 219); text-decoration: none; padding: 10px 20px; color: white; border-radius: 4px; display: inline-block;">
    Continuer en tant qu'invité
</a>

</div>

        
        <p class="texte-login">Merci de vous adresser à votre pilote pour toute perte ou oubli de votre mot de passe.</p>
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