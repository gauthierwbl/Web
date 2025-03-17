<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Dashboard - Administration</title>
  <link rel="stylesheet" href="../../css/style-admin.css">
  <link rel="icon" type="image/png" href="../../../../../../../img/icon.png" />
  <!-- Font Awesome Cdn Link -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"/>
</head>
<body class="body-admin" style="background: url(../../img/background.png) no-repeat center center fixed;">
  <!-- Haut de page -->
  <div class="main-top">
    <div class="menu-toggle">
      <i class="fas fa-bars"></i>
    </div>
    <div class="titre-navbar">Tableau de bord</div>
  </div>

  <!-- Navigation latérale -->
  <nav class="nav-laterale">
    <ul>
      <br><br><br>
      <li>
        <a class="nom-nav" href="/">
          <i class="fas fa-home"></i>
          <span class="nav-item">Home</span>
        </a>
      </li>
      <li>
        <a class="nom-nav" href="/admin/entreprise">
          <i class="fas fa-store-alt"></i>
          <span class="nav-item">Entreprises</span>
        </a>
      </li>
      <li>
        <a class="nom-nav" href="/admin/offre">
          <i class="fas fa-clipboard-list"></i>
          <span class="nav-item">Offres</span>
        </a>
      </li>
      <li>
        <a class="nom-nav" href="/admin/pilote">
          <i class="fas fa-user-tie"></i>
          <span class="nav-item">Pilotes</span>
        </a>
      </li>
      <li>
        <a class="nom-nav" href="/admin/etudiants">
          <i class="fas fa-user-graduate"></i>
          <span class="nav-item">Etudiants</span>
        </a>
      </li>
      <li>
        <a class="nom-nav" href="/admin/candidatures">
          <i class="fas fa-tasks"></i>
          <span class="nav-item">Candidatures</span>
        </a>
      </li>
      <li>
        <a class="nom-nav" href="/admin">
          <i class="fas fa-chart-bar"></i>
          <span class="nav-item">Statistiques</span>
        </a>
      </li>
      <li>
        <a class="nom-nav" href="/profile">
          <i class="fas fa-user"></i>
          <span class="nav-item">Profil</span>
        </a>
      </li>
      <li>
        <a class="nom-nav logout" href="/logout">
          <i class="fas fa-sign-out-alt"></i>
          <span class="nav-item">Déconnexion</span>
        </a>
      </li>
    </ul>
  </nav>

  <!-- Contenu principal -->
  <section class="container-admin">
    <div class="container-edit-pilote">
      <div class="top-box-position">
        <h1 class="grand-titre">Gestion des pilotes</h1>
        <form action="" method="get">
          <input class="form-control" type="search" name="terme" placeholder="Rechercher..." aria-label="Entrez votre terme de recherche">
          <input class="btn btn-recherche" type="submit" name="submit" value="Rechercher" aria-label="Rechercher">
        </form>
        <a href="admin-pilote-add.html" class="btn btn-primary">Ajouter</a>
      </div>
      <table>
        <thead>
          <tr>
            <th class="titre-tableau">#id</th>
            <th class="titre-tableau">Utilisateurs</th>
            <th class="titre-tableau">Action</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>
              <a class="texte-tableau" href="admin-pilote.html">1</a>
            </td>
            <td>
              <a class="texte-tableau" href="admin-pilote.html">Pilote Exemple</a>
            </td>
            <td>
              <a href="admin-pilote-edit.html" class="btn btn-primary-pilote">
                <span class="sr-only">Modifier le pilote</span>
                <i class="fas fa-edit"></i>
              </a>
              <form action="admin-pilote-delete.html" method="POST" style="display: inline;" onsubmit="return confirm('Voulez-vous supprimer ce pilote ?')">
                <button class="btn btn-danger-pilote">
                  <span class="sr-only">Supprimer le pilote</span>
                  <i class="fas fa-trash"></i>
                </button>
              </form>
            </td>
          </tr>
          <!-- D'autres lignes peuvent être ajoutées ici -->
        </tbody>
      </table>

      <!-- Pagination -->
      <div class="container-pagination">
        <a href="admin-etudiants.html?page=prev" class="pagination-entreprise-precedente">Page Précédente</a>
        <span style="display: inline-block; width: 20px;"></span> <!-- Espace de 20px -->
        <a href="admin-etudiants.html?page=next" class="pagination-entreprise-suivante">Page Suivante</a>
    </div>  
  </section>

  <script src="/js/script.js"></script>
  <script src="/js/script-admin.js"></script>
</body>
</html>
