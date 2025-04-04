<?php
// Ajouter cette ligne au tout début du fichier
if (defined('PAGE_ALREADY_LOADED')) return;
define('PAGE_ALREADY_LOADED', true);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Gestion des Offres</title>
  <link rel="stylesheet" href="../../css/style-admin.css">
  <link rel="icon" type="image/png" href="../../../../../../../img/icon.png" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"/>
  <style>
    .header-container {
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      margin: 20px auto;
      width: 100%;
      text-align: center;
    }

    .search-container {
      display: flex;
      justify-content: center;
      margin: 15px auto;
      max-width: 500px;
      width: 100%;
    }

    .search-container .form-control {
      width: 100%;
      padding: 8px 12px;
      border: 1px solid #ddd;
      border-radius: 4px 0 0 4px;
    }

    .search-container .btn-recherche {
      background-color: #4e73df;
      color: white;
      border: none;
      padding: 8px 15px;
      border-radius: 0 4px 4px 0;
    }

    /* Style pour les résultats de recherche */
    .results-info {
      display: flex;
      justify-content: center;
      align-items: center;
      margin: 15px auto;
      text-align: center;
      width: 100%;
      font-size: 16px;
      color: #4e73df;
    }

    .results-info a {
      margin-left: 10px;
      color: #4e73df;
      text-decoration: none;
    }

    .results-info a:hover {
      text-decoration: underline;
    }

    .no-results-dashboard {
      background-color: #fff3f3;
      padding: 15px;
      border-radius: 4px;
      border-left: 4px solid #e74a3b;
      color: #e74a3b;
      text-align: center;
      margin: 20px 0;
    }
    
    .title-center {
      text-align: center;
      margin-bottom: 15px;
    }
    
    .container-edit-offre {
      text-align: center;
    }
    
    table {
      margin: 0 auto;
      width: 100%;
      max-width: 800px;
      border-collapse: collapse;
    }
    
    table th, table td {
      text-align: center;
    }
    
    table th:first-child, table td:first-child {
      width: 10%;
    }
    
    table th:nth-child(2), table td:nth-child(2) {
      width: 35%;
    }
    
    table th:nth-child(3), table td:nth-child(3) {
      width: 35%;
    }
    
    table th:last-child, table td:last-child {
      width: 20%;
    }
    
    .container-pagination {
      text-align: center;
      margin-top: 20px;
    }
    
    .main-top {
      text-align: center;
    }
    
    .table-container {
      width: 100%;
      display: flex;
      justify-content: center;
      margin: 20px 0;
    }
    
    table thead {
      background-color: #f8f9fc;
    }
    
    table thead th {
      padding: 12px;
    }
    
    table tbody tr:nth-child(odd) {
      background-color: #f8f9fc;
    }
    
    table tbody tr:hover {
      background-color: #f0f4ff;
    }
    
    table tbody td {
      padding: 10px;
    }
  </style>
</head>
<body class="body-admin" style="background: url(../../img/background.png) no-repeat center center fixed;">
  <div class="main-top">
    <div class="menu-toggle">
      <i class="fas fa-bars"></i>
    </div>
    <div class="titre-navbar">TABLEAU DE BORD</div>
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
      <a class="nom-nav" href="index.php?module=profil&action=index">
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
    <br><br>
    <div class="header-container">
      <h1 class="grand-titre">Gestion des Offres</h1>
      
      <!-- Formulaire de recherche -->
      <div class="search-container">
        <form action="index.php" method="get">
          <input type="hidden" name="module" value="offres">
          <input type="hidden" name="action" value="recherche_dashboard">
          <input class="form-control" type="search" name="terme" placeholder="Rechercher une offre...">
          <input class="btn-recherche" type="submit" value="Rechercher">
        </form>
      </div>
      
      <?php if (isset($_GET['terme']) && !empty($_GET['terme'])): ?>
        <div class="results-info">
          <span>Résultats de recherche pour "<?= htmlspecialchars($_GET['terme']) ?>"</span>
          <a href="index.php?module=offres&action=index_dashboard">Voir toutes les offres</a>
        </div>
      <?php endif; ?>
    </div>

    <div class="table-container">
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
                <td><?= htmlspecialchars($offre['id_offre']) ?></td>
                <td><?= htmlspecialchars($offre['nom_offre']) ?></td>
                <td><?= htmlspecialchars($offre['nom_entreprise']) ?></td>
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
            <tr>
              <td colspan="4" class="no-results-dashboard">
                <?php if (isset($_GET['terme'])): ?>
                  Aucune offre ne correspond à votre recherche "<?= htmlspecialchars($_GET['terme']) ?>".
                <?php else: ?>
                  Aucune offre trouvée.
                <?php endif; ?>
              </td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>

    <!-- Pagination -->
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
  </section>

  <script src="/js/script.js"></script>
  <script src="/js/script-admin.js"></script>
</body>
</html>