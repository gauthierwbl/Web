<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard - Administration - Modification Entreprise</title>
  <link rel="stylesheet" href="../../css/style-admin.css">
  <link rel="icon" type="image/png" href="../../../../../../../img/icon.png" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"/>
</head>
<body class="body-admin" style="background: url(../../img/background.png) no-repeat center center fixed;">

  <div class="main-top">
    <div class="menu-toggle"><i class="fas fa-bars"></i></div>
    <div class="titre-navbar">Tableau de bord</div>
  </div>

  <nav class="nav-laterale">
    <ul><br><br><br>
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
    <div class="container-modifier">
      <h1 class="grand-titre">Modifier : <?= htmlspecialchars($entreprise['nom_entreprise']) ?></h1>

      <form action="index.php?module=entreprises&action=update&id=<?= htmlspecialchars($entreprise['id_entreprise']) ?>" method="POST" class="verif">
        <div class="form-group">
          <label for="nom_entreprise">Nom Entreprise</label>
          <input type="text" name="nom_entreprise" id="nom_entreprise" class="form-control" value="<?= htmlspecialchars($entreprise['nom_entreprise']) ?>" required>
        </div>

        <div class="form-group">
          <label for="id_secteur">Secteur d'activité *</label>
          <select name="id_secteur" class="form-control" id="id_secteur" required>
            <option value="1" <?= $entreprise['id_secteur'] == 1 ? 'selected' : '' ?>>Secteur 1</option>
            <option value="2" <?= $entreprise['id_secteur'] == 2 ? 'selected' : '' ?>>Secteur 2</option>
            <option value="3" <?= $entreprise['id_secteur'] == 3 ? 'selected' : '' ?>>Secteur 3</option>
          </select>
        </div>

        <div class="form-group">
          <label for="id_fichier">ID Fichier (Logo)</label>
          <input type="text" name="id_fichier" id="id_fichier" class="form-control" value="<?= htmlspecialchars($entreprise['id_fichier']) ?>">
        </div>

        <div class="form-group">
          <label for="is_visible">Visible sur le site</label>
          <input type="checkbox" name="is_visible" id="is_visible" <?= $entreprise['is_visible'] ? 'checked' : '' ?>>
        </div>

        <button type="submit" class="btn btn-primary">Modifier</button>
      </form>
    </div>
  </section>

  <script src="/js/script.js"></script>
  <script src="/js/script-admin.js"></script>
</body>
</html>
