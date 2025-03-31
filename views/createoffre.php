<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer une offre</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            padding: 20px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }
        form {
            width: 100%;
            max-width: 600px;
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }
        input, textarea, select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        button {
            padding: 10px 20px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
        }
        button:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <h2>Créer une nouvelle offre</h2>
    <form action="index.php?action=store" method="POST">
        <label for="nom_offre">Nom de l'offre</label>
        <input type="text" id="nom_offre" name="nom_offre" required>

        <label for="description_offre">Description de l'offre</label>
        <textarea id="description_offre" name="description_offre" required></textarea>

        <label for="id_mineure">Mineure</label>
        <input type="text" id="id_mineure" name="id_mineure">

        <label for="competences">Compétences requises</label>
        <input type="text" id="competences" name="competences">

        <label for="duree_stage">Durée du stage</label>
        <input type="text" id="duree_stage" name="duree_stage">

        <label for="base_remuneration">Base de rémunération</label>
        <input type="text" id="base_remuneration" name="base_remuneration">

        <label for="date_offre">Date de l'offre</label>
        <input type="date" id="date_offre" name="date_offre" required>

        <label for="nombre_place">Nombre de places</label>
        <input type="number" id="nombre_place" name="nombre_place" required>

        <label for="nombre_candidature">Nombre de candidatures</label>
        <input type="number" id="nombre_candidature" name="nombre_candidature" required>

        <label for="id_entreprise">Entreprise</label>
        <select id="id_entreprise" name="id_entreprise" required>
            <!-- Remplir avec les entreprises disponibles dans la base de données -->
            <option value="1">Entreprise A</option>
            <option value="2">Entreprise B</option>
        </select>

        <button type="submit">Créer l'offre</button>
    </form>
</body>
</html>
