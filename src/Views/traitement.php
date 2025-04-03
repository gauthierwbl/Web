<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload de fichier</title>
    <style>
       body {
    font-family: Arial, sans-serif;
    background-color: #f8f9fa;
    margin: 0;
    padding: 0;
    display: flex;
    flex-direction: column; /* Met tous les éléments en colonne */
    justify-content: center;
    align-items: center;
    height: 100vh;
}

.container {
    background: white;
    margin-top: 1rem;
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
    text-align: center;
    width: 400px;
    display: flex;
    flex-direction: column; /* Force l'affichage en colonne */
    gap: 15px; /* Ajoute de l'espace entre les éléments */
}


        h2 {
            color: #333;
            margin-bottom: 15px;
        }

        p {
            color: #666;
            font-size: 14px;
            margin-bottom: 20px;
        }

        input[type="file"] {
            display: none;
        }

        label {
            background-color: #007bff;
            color: white;
            padding: 12px 20px;
            border-radius: 5px;
            cursor: pointer;
            display: inline-block;
            font-size: 14px;
            font-weight: bold;
            transition: background 0.3s ease;
        }

        label:hover {
            background-color: #0056b3;
        }

        .file-name {
            margin-top: 10px;
            font-size: 14px;
            color: #333;
        }

        textarea {
            width: 100%;
            height: 150px;
            padding: 10px;
            font-size: 14px;
            border: 1px solid #ccc;
            border-radius: 5px;
            resize: none;
        }

        button {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
            margin-top: 15px;
            transition: background 0.3s ease;
        }

        button:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>

    <div class="container">
    <?php if (!empty($message)): ?>
            <div class="message <?php echo $error ? 'error' : 'success'; ?>">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <h2>Uploader un fichier PDF</h2>
        <p>Formats acceptés : <strong>PDF uniquement</strong> (max 2 Mo)</p>
        
    <form action="index.php?module=Traitement&action=index" method="post" enctype="multipart/form-data">
    <!-- Champ caché pour l'ID de l'offre -->
    <input type="hidden" name="id_offre" value="<?= htmlspecialchars($offre['id_offre']) ?>">

    <input type="file" name="file" id="file" accept=".pdf" required>
    <label for="file">Choisir un fichier</label>
    <p class="file-name" id="file-name">Aucun fichier sélectionné</p>

    <h2>Lettre de motivation</h2>
    <input type="hidden" name="id_offre" value="<?php echo $offre_id; ?>">
    <textarea name="lettre_motivation" placeholder="Écrivez votre lettre de motivation ici..." required></textarea>

    <button type="submit" name="submit">Téléverser</button>
    </form>

    </div>

    <script>
        document.getElementById("file").addEventListener("change", function() {
            var fileName = this.files[0] ? this.files[0].name : "Aucun fichier sélectionné";
            document.getElementById("file-name").textContent = fileName;
        });
    </script>

</body>
</html>
