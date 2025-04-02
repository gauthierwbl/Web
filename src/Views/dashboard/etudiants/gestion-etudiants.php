<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Dashboard - Administration Étudiants</title>
  <link rel="stylesheet" href="../../css/style-admin.css">
  <link rel="icon" type="image/png" href="../../img/icon.png" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"/>
</head>
<body class="body-admin" style="background: url(../../img/background.png) no-repeat center center fixed;">

  <!-- Haut de page -->
  <div class="main-top">
    <div class="menu-toggle"><i class="fas fa-bars"></i></div>
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
      <a class="nom-nav" href="index.php?module=candidatures&action=index_dashboard">
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

  <!-- Contenu principal -->
  <section class="container-admin">
    <div class="container-edit-etudiant">
      <div class="top-box-position">
        <h1 class="grand-titre">Gestion des étudiants</h1>

        <form action="" method="get">
          <input class="form-control" type="search" name="terme" placeholder="Rechercher..." aria-label="Entrez votre terme de recherche">
          <input class="btn btn-recherche" type="submit" name="submit" value="Rechercher" aria-label="Rechercher">
          <a href="index.php?module=etudiants&action=create" class="btn btn-primary">Ajouter</a>
        </form>
      </div>

      <table>
        <thead>
          <tr>
            <th class="titre-tableau">#ID</th>
            <th class="titre-tableau">Nom</th>
            <th class="titre-tableau">Prénom</th>
            <th class="titre-tableau">Login</th>
            <th class="titre-tableau">Date inscription</th>
            <th class="titre-tableau">Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($etudiants as $etudiant): ?>
            <tr>
              <td><?= htmlspecialchars($etudiant['id_utilisateurs']) ?></td>
              <td><?= htmlspecialchars($etudiant['nom']) ?></td>
              <td><?= htmlspecialchars($etudiant['prenom']) ?></td>
              <td><?= htmlspecialchars($etudiant['login']) ?></td>
              <td><?= htmlspecialchars($etudiant['date_inscription']) ?></td>
              <td>
                <a href="index.php?module=etudiants&action=edit&id=<?= $etudiant['id_utilisateurs'] ?>" class="btn btn-primary-etudiant">
                  <i class="fas fa-edit"></i>
                </a>
                <form action="index.php?module=etudiants&action=delete&id=<?= $etudiant['id_utilisateurs'] ?>" method="POST" style="display:inline;" onsubmit="return confirm('Supprimer cet étudiant ?');">
                  <button class="btn btn-danger-etudiant"><i class="fas fa-trash"></i></button>
                </form>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>

      <!-- Pagination -->
      <div class="container-pagination">
        <?php if (isset($pageActuelle) && isset($totalPages)): ?>
          <?php if ($pageActuelle > 1): ?>
            <a href="index.php?module=etudiants&action=index_dashboard&page=<?= $pageActuelle - 1 ?>" class="pagination-entreprise-precedente">Page Précédente</a>
          <?php endif; ?>
          <span style="display: inline-block; width: 20px;"></span>
          <?php if ($pageActuelle < $totalPages): ?>
            <a href="index.php?module=etudiants&action=index_dashboard&page=<?= $pageActuelle + 1 ?>" class="pagination-entreprise-suivante">Page Suivante</a>
          <?php endif; ?>
        <?php endif; ?>
      </div>
    </div>
  </section>

  <script src="/js/script.js"></script>
  <script src="/js/script-admin.js"></script>
</body>
</html>
