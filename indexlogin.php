<?php
session_start();

// Inclure uniquement ce qui est nécessaire pour la connexion.
require_once 'src/models/Database.php';
require_once 'src/models/UserModel.php';

// Initialisation de la connexion et du modèle.
$pdo = (new Database())->getConnection();
$userModel = new UserModel($pdo);

// Afficher directement $_POST pour voir si les données arrivent.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    var_dump($_POST);
    $username = $_POST['login'] ?? '';
    $password = $_POST['password'] ?? '';

    // Si des données sont soumises, on essaie de récupérer l'utilisateur.
    $user = $userModel->findUserByUsername($username);

    // Vérification des données récupérées.
    var_dump($user);

    if ($user) {
        // Vérifier le mot de passe.
        if (password_verify($password, $user['mot_de_passe'])) {
            header('Location: index.php?module=entreprise&action=index');
exit;

        } else {
            echo "Password incorrect.";
        }
    } else {
        echo "User not found.";
    }
    exit;
}

// Si pas de POST, afficher un formulaire basique.
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login Test</title>
</head>
<body>
    <h1>Login</h1>
    <form method="post" action="">
        <label>Login:</label>
        <input type="text" name="login" />
        <label>Password:</label>
        <input type="password" name="password" />
        <button type="submit">Submit</button>
    </form>
</body>
</html>