<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier une entreprise</title>
</head>
<body>
    <h2>Modifier une entreprise</h2>
    <form action="index.php?action=update&id=<?= htmlspecialchars($entreprise['id_entreprise']) ?>" method="post">
    <label>Nom de l'entreprise : <input type="text" name="nom_entreprise" value="<?= htmlspecialchars($entreprise['nom_entreprise']) ?>" required></label><br><br>
    <label>ID secteur : <input type="number" name="id_secteur" value="<?= htmlspecialchars($entreprise['id_secteur']) ?>" required></label><br><br>
    <label>ID fichier : <input type="number" name="id_fichier" value="<?= htmlspecialchars($entreprise['id_fichier']) ?>"></label><br><br>
    <label>Visible ? <input type="checkbox" name="is_visible" <?= $entreprise['is_visible'] ? 'checked' : '' ?>></label><br><br>
    <button type="submit">Modifier</button>
</form>
    <p><a href="index.php?action=index">← Retour à la liste</a></p>
</body>
</html>
