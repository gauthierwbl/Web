<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter une entreprise</title>
</head>
<body>
    <h2>Ajouter une entreprise</h2>
    <form action="index.php?action=store" method="post">
    <label>Nom de l'entreprise : <input type="text" name="nom_entreprise" required></label><br><br>
    <label>ID secteur : <input type="number" name="id_secteur" required></label><br><br>
    <label>ID fichier : <input type="number" name="id_fichier" value="50"></label><br><br>
    <label>Visible ? <input type="checkbox" name="is_visible" checked></label><br><br>
    <button type="submit">Enregistrer</button>
</form>
    <p><a href="index.php?action=index">← Retour à la liste</a></p>
</body>
</html>
