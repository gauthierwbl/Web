<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Offres de stage - Pagination</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            padding: 0;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }
        h2 {
            color: #333;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 20px;
        }
        table {
            width: 80%;
            margin: 0 auto;
            border-collapse: collapse;
            background: white;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
        }
        th, td {
            padding: 15px;
            text-align: left;
        }
        th {
            background-color: #343a40;
            color: white;
            font-weight: bold;
            text-transform: uppercase;
        }
        tr:nth-child(even) { background-color: #f2f2f2; }
        tr:hover { background-color: #ddd; }
        .pagination {
            margin-top: 20px;
        }
        .pagination a {
            display: inline-block;
            margin: 5px;
            padding: 10px 15px;
            text-decoration: none;
            color: #333;
            border-radius: 5px;
            border: 1px solid #ddd;
            transition: all 0.3s ease-in-out;
        }
        .pagination a:hover {
            background-color: #343a40;
            color: white;
            border-color: #343a40;
        }
        .pagination a.active {
            background-color: #007bff;
            color: white;
            border-color: #007bff;
            font-weight: bold;
        }
        .icon-link {
            text-decoration: none;
            font-size: 20px;
        }
    </style>
</head>
<body>
    <h2>Liste des offres</h2>
    <p><a href="index.php?action=create" style="padding:10px;background-color:#28a745;color:white;border-radius:5px;text-decoration:none;">➕ Ajouter une offre</a></p>

    <?php if (isset($offresAffichees) && is_array($offresAffichees) && count($offresAffichees) > 0): ?>
        <table>
            <tr>
                <th>Titre</th>
                <th>Secteur</th>
                <th>Fichier</th>
                <th>Actions</th>
            </tr>
            <?php foreach ($offresAffichees as $offre): ?>
            <tr>
                <td><?= htmlspecialchars($offre['nom_offre']) ?></td>
                <td><?= htmlspecialchars($offre['description_offre']) ?></td>
                <td><?= htmlspecialchars($offre['id_mineure']) ?></td>
                <td>
                    <a class="icon-link" href="index.php?action=edit&id=<?= $offre['id_offre'] ?>">✏️</a>
                    <a class="icon-link" href="index.php?action=delete&id=<?= $offre['id_offre'] ?>" onclick="return confirm('Confirmer la suppression ?');">🗑️</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <p style="color: red;">Aucune offre trouvée.</p>
    <?php endif; ?>

    <div class="pagination">
    <?php if (isset($pageActuelle) && isset($totalPages)): ?>
        <?php if ($pageActuelle > 1): ?>
            <a href="index.php?module=offres&action=index&page=<?= $pageActuelle - 1 ?>">Précédent</a>
        <?php endif; ?>

        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <a href="index.php?module=offres&action=index&page=<?= $i ?>" class="<?= ($i == $pageActuelle) ? 'active' : '' ?>"><?= $i ?></a>
        <?php endfor; ?>

        <?php if ($pageActuelle < $totalPages): ?>
            <a href="index.php?module=offres&action=index&page=<?= $pageActuelle + 1 ?>">Suivant</a>
        <?php endif; ?>
    <?php endif; ?>
</div>
</body>
</html>
