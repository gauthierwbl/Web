<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Dashboard - Administration - Candidatures</title>
  <link rel="stylesheet" href="../../css/style-admin.css">
  <link rel="icon" type="image/png" href="../../img/icon.png" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"/>
</head>
<body class="body-admin" style="background: url(../../img/background.png) no-repeat center center fixed;">
  <div class="main-top">
    <div class="menu-toggle">
      <i class="fas fa-bars"></i>
    </div>
    <div class="titre-navbar">Tableau de bord</div>
  </div>

  <!-- Navigation latérale -->
  <nav class="nav-laterale">
  <ul><br><br><br>
    <li>
      <a class="nom-nav" href="index.php?module=entreprises&action=index">
        <i class="fas fa-home"></i>
        <span class="nav-item">Home</span>
      </a>
    </li>
    <li>
      <a class="nom-nav" href="index.php?module=entreprises&action=index_dashboard">
        <i class="fas fa-store-alt"></i>
        <span class="nav-item">Entreprises</span>
      </a>
    </li>
    <li>
      <a class="nom-nav" href="index.php?module=offres&action=index_dashboard">
        <i class="fas fa-clipboard-list"></i>
        <span class="nav-item">Offres</span>
      </a>
    </li>
    <li>
      <a class="nom-nav" href="index.php?module=pilotes&action=index_dashboard">
        <i class="fas fa-user-tie"></i>
        <span class="nav-item">Pilotes</span>
      </a>
    </li>
    <li>
      <a class="nom-nav" href="index.php?module=etudiants&action=index_dashboard">
        <i class="fas fa-user-graduate"></i>
        <span class="nav-item">Étudiants</span>
      </a>
    </li>
    <li>
      <a class="nom-nav" href="index.php?module=candidatures&action=index">
        <i class="fas fa-tasks"></i>
        <span class="nav-item">Candidatures</span>
      </a>
    </li>
    <li>
      <a class="nom-nav" href="index.php?module=Statistiques&action=index">
        <i class="fas fa-chart-bar"></i>
        <span class="nav-item">Statistiques</span>
      </a>
    </li>
    <li>
      <a class="nom-nav" href="index.php?module=profile&action=view">
        <i class="fas fa-user"></i>
        <span class="nav-item">Profil</span>
      </a>
    </li>
    <li>
      <a class="nom-nav logout" href="index.php?module=auth&action=logout">
        <i class="fas fa-sign-out-alt"></i>
        <span class="nav-item">Déconnexion</span>
      </a>
    </li>
  </ul>
</nav>

  <section class="container-admin">
    <div class="container-edit-candidatures">
      <h1 class="grand-titre">Gestion des Candidatures</h1>

      <!-- Formulaire de recherche -->
      <form action="" method="get">
        <input class="form-control" type="search" name="terme" placeholder="Rechercher..." aria-label="Entrez votre terme de recherche">
        <input class="btn btn-recherche" type="submit" name="submit" value="Rechercher" aria-label="Rechercher">
      </form>

      <!-- Tableau des candidatures -->
      <table>
        <thead>
          <tr>
            <th>#id</th>
            <th>Entreprise</th>
            <th>Offre</th>
            <th>Lettre de motivation</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php if (!empty($offresCandidaturees)): ?>
            <?php foreach ($offresCandidaturees as $offre): ?>
              <tr>
                <td><?= htmlspecialchars($offre['id_offre']) ?></td>
                <td><?= htmlspecialchars($offre['nom_entreprise']) ?></td>
                <td><?= htmlspecialchars($offre['nom_offre']) ?></td>
                <td><?= htmlspecialchars($offre['lettre_motivation']) ?></td>
                <td>
                  <!-- Bouton pour modifier la candidature -->
                  <a href="index.php?module=candidatures&action=edit&id=<?= $offre['id_utilisateurs'] ?>&id_o=<?= $offre['id_offre'] ?>" class="btn btn-primary-candidature">
                    <span class="sr-only">Modifier la candidature</span>
                    <i class="fas fa-edit"></i>
                  </a>
                  <!-- Formulaire pour supprimer la candidature -->
                  <form action="admin-candidature-delete.html?id=<?= $offre['id_offre'] ?>&id_o=<?= $offre['id_offre'] ?>" method="POST" style="display: inline;" onsubmit="return confirm('Voulez-vous supprimer cette candidature ?')">
                    <button class="btn btn-danger-candidature">
                      <span class="sr-only">Supprimer la candidature</span>
                      <i class="fas fa-trash"></i>
                    </button>
                  </form>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr><td colspan="5">Aucune candidature trouvée.</td></tr>
          <?php endif; ?>
        </tbody>
      </table>

      <!-- Pagination -->
      <div class="container-pagination">
        <?php if ($pageActuelle > 1): ?>
          <a href="index.php?module=candidatures&action=index&page=<?= $pageActuelle - 1 ?>" class="pagination-entreprise-precedente">Page Précédente</a>
        <?php endif; ?>
        <span style="display: inline-block; width: 20px;"></span>
        <?php if ($pageActuelle < $totalPages): ?>
          <a href="index.php?module=candidatures&action=index&page=<?= $pageActuelle + 1 ?>" class="pagination-entreprise-suivante">Page Suivante</a>
        <?php endif; ?>
      </div>
    </div>
  </section>

  <script src="/js/script.js"></script>
  <script src="/js/script-admin.js"></script>
</body>
</html>
