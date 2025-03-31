<?php var_dump($stages); ?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stages Validés</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body style="background-image: url('img/background.png');">

    <header class="navbar">
        <section class="contenu-nav">
            <div class="gauche">
                <a href="/">
                    <label>
                        <img class="logo" src="img/logo.png" alt="logo_img"/>
                    </label>
                </a>
            </div>
            <div class="milieu">
                <ul>
                    <li><a href="/entreprise">Entreprises</a></li>
                    <li><a href="/offre">Offres</a></li>
                    <li><a href="/contact">Contact</a></li>
                    <li><button id="bouton-projets">Menu</button></li>
                </ul>
                <div id="icons"></div>
                <div class="droite">
                    <a href="/profile">
                        <label>
                            <img class="profil profil-img" src="img/profil.png" alt="photo_de_profile"/>
                        </label>
                    </a>
                </div>
            </div>
        </section>
    </header>

    <div class="titre-postuler">Mes Stages</div>

    <div class="offer">
    <table class="table-stages">
        <tr>
            <th>Détail de l'offre</th>
            <th>Lettre de Motivation</th>
            <th>ID du fichier</th>
            <th>Actions</th>
        </tr>
        <?php if (!empty($stages)): ?>
            <?php foreach ($stages as $stage) : ?>
                <tr>
                    <td><?= htmlspecialchars($stage['id_offre']) ?></td>
                    <td><?= htmlspecialchars($stage['lettre_motivation']) ?></td>
                    <td><?= htmlspecialchars($stage['id_fichier']) ?></td>
                    <td>
                        <a class="btn-modifier" href="index.php?action=edit_stage&id=<?= $stage['id_offre'] ?>">
                            <i class="fas fa-edit"></i> Modifier
                        </a>
                        <a class="btn-supprimer" href="index.php?action=delete_stage&id=<?= $stage['id_offre'] ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce stage ?');">
                            <i class="fas fa-trash-alt"></i> Supprimer
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="4" style="text-align: center;">Aucun stage validé pour le moment.</td>
            </tr>
        <?php endif; ?>
    </table>
    </div>
  

    <footer class="text-center" id="footer">
        <div class="container">
            <ul class="list-inline">
                <li class="list-inline-item me-4"><a class="link-secondary" href="/condition">Conditions générales</a></li>
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
                    <a href="https://twitter.com/Cesi Ton Stage" aria-label="Lien vers notre compte Twitter"><i class="fab fa-twitter"></i></a>
                </div>
                <a href="https://twitter.com/Cesi Ton Stage">Suivez-nous sur Twitter</a>
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
</html>
