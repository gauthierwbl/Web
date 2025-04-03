<?php

// Supprimer toutes les variables de session
$_SESSION = [];

// Supprimer le cookie de session s'il y en a un
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Détruire la session
session_destroy();
// Rediriger vers index.php?action=login (chemin relatif, dynamique et portable)
header("Location: index.php?module=connexion");
exit;

