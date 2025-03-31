<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier le Stage</title>
</head>
<body>
    <h1>Modifier le Stage</h1>
    <form action="index.php?action=update_stage&id=<?= $stage['id_offre'] ?>" method="POST">
        <label>Lettre de Motivation:</label><br>
        <textarea name="lettre_motivation"><?= htmlspecialchars($stage['lettre_motivation']) ?></textarea><br>

        <button type="submit">Modifier</button>
    </form>
</body>
</html>
