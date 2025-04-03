<?php

if ($_SESSION['user']['id_role'] == 2 || $_SESSION['user']['id_role'] == 4) {
  // Rediriger l'utilisateur vers la page d'erreur
  header('Location: src/views/erreur.php');
  exit;
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard - Administration - Statistiques</title>
  <link rel="stylesheet" href="../css/style-admin.css">
  <link rel="icon" type="image/png" href="../../../../../../../img/icon.png" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"/>
</head>
<body class="body-admin" style="background: url(../img/background.png) no-repeat center center fixed;">
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
    <?php if (isset($_SESSION['user']) && $_SESSION['user']['id_role'] == 1): ?>
    <li>
        <a class="nom-nav" href="index.php?module=pilotes&action=index_dashboard">
            <i class="fas fa-user-tie"></i>
            <span class="nav-item">Pilotes</span>
        </a>
    </li>
<?php endif; ?>
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

  <!-- Contenu principal -->
<section class="container-admin">
  <section class="main table-responsive">
    <h1 class="grand-titre-stats">Statistiques</h1>

    <div style="display: flex; flex-wrap: wrap; gap: 30px; justify-content: space-between;">

      <!-- Statistiques par Entreprise -->
      <div style="flex: 1 1 30%; min-width: 300px;">
        <h4 class="petit-titre">Nombre de stages par entreprise</h4>
        <table class="table table-striped">
          <thead>
            <tr><th>Entreprise</th><th>Nombre</th></tr>
          </thead>
          <tbody>
            <?php foreach ($stagesParEntreprise as $item): ?>
              <tr>
                <td><?= htmlspecialchars($item['nom_entreprise']) ?></td>
                <td><?= $item['nb_stages'] ?></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>

      <!-- Statistiques par Durée du stage -->
      <div style="flex: 1 1 30%; min-width: 300px;">
        <h4 class="petit-titre">Nombre de stages par durée (semaines)</h4>
        <table class="table table-striped">
          <thead>
            <tr><th>Durée</th><th>Nombre</th></tr>
          </thead>
          <tbody>
            <?php foreach ($stagesParDuree as $item): ?>
              <tr>
                <td><?= htmlspecialchars($item['duree_stage']) ?></td>
                <td><?= $item['nb_stages'] ?></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>

      <!-- Top des stages en Wishlist -->
      <div style="flex: 1 1 30%; min-width: 300px;">
        <h4 class="petit-titre">Top des stages wishlist</h4>
        <table class="table table-striped">
          <thead>
            <tr><th>Offre</th><th>Ajouts</th></tr>
          </thead>
          <tbody>
            <?php foreach ($topWishlist as $item): ?>
              <tr>
                <td><?= htmlspecialchars($item['nom_offre']) ?></td>
                <td><?= $item['nb_wishlist'] ?></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>

    </div>
  </section>
</section>

  <script src="/js/script.js"></script>
  <script src="/js/script-admin.js"></script>
</body>
</html>
