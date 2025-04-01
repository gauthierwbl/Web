<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard - Administration - Modification Offre</title>
  <link rel="stylesheet" href="../../css/style-admin.css">
  <link rel="icon" type="image/png" href="../../../../../../../img/icon.png">
  <!-- Font Awesome CDN Link -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body class="body-admin" style="background: url(../../img/background.png) no-repeat center center fixed;">
  <!-- Haut de page -->
  <div class="main-top">
    <div class="menu-toggle"><i class="fas fa-bars"></i></div>
    <div class="titre-navbar">Tableau de bord</div>
  </div>
  
  <!-- Navigation latérale -->
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
  
  <!-- Contenu principal -->
  <section class="container-admin">
    <div class="container-modifier">
      <h1 class="grand-titre"><?= htmlspecialchars($offre['nom_offre']) ?></h1>

      <form action="index.php?module=offres&action=update" method="post" class="verif">
        <input type="hidden" name="id_offre" value="<?= htmlspecialchars($offre['id_offre']) ?>">

        <div class="form-group">
          <label for="nom_offre">Nom Offre</label>
          <input type="text" name="nom_offre" id="nom_offre" class="form-control" value="<?= htmlspecialchars($offre['nom_offre']) ?>">
        </div>

        <div class="form-group">
          <label for="description_offre">Description Offre</label>
          <textarea name="description_offre" id="description_offre" class="form-control"><?= htmlspecialchars($offre['description_offre']) ?></textarea>
        </div>

        <div class="form-group">
          <label for="competences">Compétences</label>
          <input type="text" name="competences" id="competences" class="form-control" value="<?= htmlspecialchars($offre['competences']) ?>">
        </div>

        <div class="form-group">
          <label for="duree_stage">Durée de stage</label>
          <input type="text" name="duree_stage" id="duree_stage" class="form-control" value="<?= htmlspecialchars($offre['duree_stage']) ?>">
        </div>

        <div class="form-group">
          <label for="base_remuneration">Base de rémunération</label>
          <input type="text" name="base_remuneration" id="base_remuneration" class="form-control" value="<?= htmlspecialchars($offre['base_remuneration']) ?>">
        </div>

        <div class="form-group">
          <label for="date_offre">Date de l'offre</label>
          <input type="date" name="date_offre" id="date_offre" class="form-control" value="<?= htmlspecialchars($offre['date_offre']) ?>">
        </div>

        <div class="form-group">
          <label for="nombre_place">Nombre de places disponibles</label>
          <input type="number" name="nombre_place" id="nombre_place" class="form-control" value="<?= htmlspecialchars($offre['nombre_place']) ?>">
        </div>

        <div class="form-group">
          <label for="nombre_candidature">Nombre de candidatures</label>
          <input type="number" name="nombre_candidature" id="nombre_candidature" class="form-control" value="<?= htmlspecialchars($offre['nombre_candidature']) ?>">
        </div>

        <div class="form-group">
          <label for="id_entreprise">Entreprise *</label>
          <select name="id_entreprise" id="id_entreprise" class="form-control" required>
            <option value="<?= $offre['id_entreprise'] ?>" selected><?= $offre['id_entreprise'] ?></option>
            <!-- Optionnel : ajouter dynamiquement d'autres entreprises ici -->
          </select>
        </div>

        <div class="form-group">
          <label for="id_mineure">Mineure *</label>
          <select name="id_mineure" id="id_mineure" class="form-control" required>
            <option value="<?= $offre['id_mineure'] ?>" selected><?= $offre['id_mineure'] ?></option>
            <!-- Optionnel : ajouter dynamiquement d'autres mineures ici -->
          </select>
        </div>

        <button type="submit" class="btn btn-primary">Modifier</button>
      </form>
    </div>
  </section>

  <script src="/js/script.js"></script>
  <script src="/js/script-admin.js"></script>
</body>
</html>
