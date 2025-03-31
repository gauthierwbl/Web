<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
</head>
<body>
    <h2>Connexion</h2>
    <?php if (isset($_GET['error'])): ?>
        <p style="color: red;">Identifiants incorrects. Veuillez réessayer.</p>
    <?php endif; ?>

    <form action="index.php?action=login" method="post">
        <label for="username">Nom d'utilisateur :</label>
        <input type="text" name="username" id="username" required><br>

        <label for="password">Mot de passe :</label>
        <input type="password" name="password" id="password" required><br>

        <button type="submit">Connexion</button>
    </form>
</body>
</html>
