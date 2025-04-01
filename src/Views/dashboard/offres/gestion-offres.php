<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Gestion des Offres</title>
  <link rel="stylesheet" href="../../css/style-admin.css">
  <link rel="icon" type="image/png" href="../../../../../../../img/icon.png" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"/>
</head>
<body class="body-admin" style="background: url(../../img/background.png) no-repeat center center fixed;">
  <div class="main-top">
    <div class="menu-toggle">
      <i class="fas fa-bars"></i>
    </div>
    <div class="titre-navbar">Tableau de bord</div>
  </div>

  <nav class="nav-laterale">
    <ul>
      <br><br><br>
      <li><a class="nom-nav" href="/"><i class="fas fa-home"></i><span class="nav-item">Home</span></a></li>
      <li><a class="nom-nav" href="/admin/entreprise"><i class="fas fa-store-alt"></i><span class="nav-item">Entreprises</span></a></li>
      <li><a class="nom-nav" href="/admin/offre"><i class="fas fa-clipboard-list"></i><span class="nav-item">Offres</span></a></li>
      <li><a class="nom-nav" href="/admin/pilote"><i class="fas fa-user-tie"></i><span class="nav-item">Pilotes</span></a></li>
      <li><a class="nom-nav" href="/admin/etudiants"><i class="fas fa-user-graduate"></i><span class="nav-item">Étudiants</span></a></li>
      <li><a class="nom-nav" href="/admin/candidatures"><i class="fas fa-tasks"></i><span class="nav-item">Candidatures</span></a></li>
      <li><a class="nom-nav" href="/admin"><i class="fas fa-chart-bar"></i><span class="nav-item">Statistiques</span></a></li>
      <li><a class="nom-nav" href="/profile"><i class="fas fa-user"></i><span class="nav-item">Profil</span></a></li>
      <li><a class="nom-nav logout" href="/logout"><i class="fas fa-sign-out-alt"></i><span class="nav-item">Déconnexion</span></a></li>
    </ul>
  </nav>

  <section class="container-admin">
    <br><br>
    <div class="container-edit-offre">
      <div class="top-box-position">
        <h1 class="grand-titre">Gestion des Offres</h1>
        <form action="" method="get">
          <input class="form-control" type="search" name="terme" placeholder="Rechercher..." aria-label="Entrez votre terme de recherche">
          <input class="btn btn-recherche" type="submit" name="submit" value="Rechercher">
        </form>
        <a href="index.php?module=offres&action=create" class="btn btn-primary">Ajouter</a>
      </div>

      <table>
        <thead>
          <tr>
            <th class="titre-tableau">#id</th>
            <th class="titre-tableau">Nom de l'offre</th>
            <th class="titre-tableau">Entreprise</th>
            <th class="titre-tableau">Action</th>
          </tr>
        </thead>
        <tbody>
          <?php if (isset($offresAffichees) && count($offresAffichees) > 0): ?>
            <?php foreach ($offresAffichees as $offre): ?>
              <tr>
                <td><a class="texte-tableau"><?= htmlspecialchars($offre['id_offre']) ?></a></td>
                <td><a class="texte-tableau"><?= htmlspecialchars($offre['nom_offre']) ?></a></td>
                <td><a class="texte-tableau"><?= htmlspecialchars($offre['nom_entreprise']) ?></a></td>
                <td>
                  <a href="index.php?module=offres&action=edit&id=<?= $offre['id_offre'] ?>" class="btn btn-primary-offre" title="Modifier">
                    <i class="fas fa-edit"></i>
                  </a>
                  <a href="index.php?module=offres&action=delete&id=<?= $offre['id_offre'] ?>" class="btn btn-danger-offre" onclick="return confirm('Voulez-vous supprimer cette offre ?')" title="Supprimer">
                    <i class="fas fa-trash"></i>
                  </a>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr><td colspan="4" style="color: red;">Aucune offre trouvée.</td></tr>
          <?php endif; ?>
        </tbody>
      </table>

      <div class="container-pagination">
        <?php if (isset($pageActuelle) && isset($totalPages)): ?>
          <?php if ($pageActuelle > 1): ?>
            <a href="index.php?module=offres&action=index_dashboard&page=<?= $pageActuelle - 1 ?>" class="pagination-entreprise-precedente">Page Précédente</a>
          <?php endif; ?>
          <span style="display: inline-block; width: 20px;"></span>
          <?php if ($pageActuelle < $totalPages): ?>
            <a href="index.php?module=offres&action=index_dashboard&page=<?= $pageActuelle + 1 ?>" class="pagination-entreprise-suivante">Page Suivante</a>
          <?php endif; ?>
        <?php endif; ?>
      </div>
    </div>
  </section>

  <script src="/js/script.js"></script>
  <script src="/js/script-admin.js"></script>
</body>
</html>
