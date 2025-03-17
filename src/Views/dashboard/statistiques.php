<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Dashboard - Administration - Statistiques</title>
  <link rel="stylesheet" href="../css/style-admin.css">
  <link rel="icon" type="image/png" href="../../../../../../../img/icon.png" />
  <!-- Font Awesome Cdn Link -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"/>
</head>
<body class="body-admin" style="background: url(../img/background.png) no-repeat center center fixed;">
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
          <span class="nav-item">Étudiants</span>
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
    <section class="main table-responsive">
      <h1 class="grand-titre-stats">Statistique Nombre de stage</h1>
      
      <!-- Statistiques par Entreprise -->
      <h4 class="petit-titre">Nombre de Stage par Entreprise</h4>
      <table class="table table-striped">
        <thead>
          <tr>
            <th>Entreprise</th>
            <th>Nombre de stages</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>Entreprise A</td>
            <td>5</td>
          </tr>
          <tr>
            <td>Entreprise B</td>
            <td>3</td>
          </tr>
          <tr>
            <td>Entreprise C</td>
            <td>8</td>
          </tr>
          <!-- D'autres lignes peuvent être ajoutées -->
        </tbody>
      </table>

      <!-- Statistiques par Durée du stage -->
      <h4 class="petit-titre">Nombre de Stage par durée du stage</h4>
      <table class="table table-striped">
        <thead>
          <tr>
            <th>Nombre de semaines</th>
            <th>Nombre de stages</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>4</td>
            <td>2</td>
          </tr>
          <tr>
            <td>8</td>
            <td>6</td>
          </tr>
          <tr>
            <td>12</td>
            <td>4</td>
          </tr>
          <!-- D'autres lignes peuvent être ajoutées -->
        </tbody>
      </table>

      <!-- Statistiques par Campus -->
      <h4 class="petit-titre">Nombre de Stage par Campus</h4>
      <table class="table table-striped">
        <thead>
          <tr>
            <th>Campus</th>
            <th>Nombre de stages</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>Campus X</td>
            <td>7</td>
          </tr>
          <tr>
            <td>Campus Y</td>
            <td>5</td>
          </tr>
          <!-- D'autres lignes peuvent être ajoutées -->
        </tbody>
      </table>

      <!-- Top des stages en Wishlist -->
      <h4 class="petit-titre">Top des stages en wishlist</h4>
      <table class="table table-striped">
        <thead>
          <tr>
            <th>Nom Offre</th>
            <th>Wishlist</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>Offre 1</td>
            <td>10</td>
          </tr>
          <tr>
            <td>Offre 2</td>
            <td>7</td>
          </tr>
          <!-- D'autres lignes peuvent être ajoutées -->
        </tbody>
      </table>
    </section>
  </section>

  <script src="/js/script.js"></script>
  <script src="/js/script-admin.js"></script>
</body>
</html>
