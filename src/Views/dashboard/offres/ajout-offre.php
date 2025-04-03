<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard - Administration - Nouvelle offre</title>
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
    <div class="container-modifier">
      <h1 class="grand-titre">Nouvelle offre</h1>
      <!-- <div class="alert alert-success">
           L'offre a bien été créée
      </div> -->
      <form action="index.php?module=offres&action=store" method="post" class="verif">
        <div class="form-group">
          <label for="nomOffre">Nom Offre</label>
          <input type="text" name="nomOffre" id="nomOffre" class="form-control" value="">
        </div>
        <div class="form-group">
          <label for="descriptionOffre">Description Offre</label>
          <textarea name="descriptionOffre" id="descriptionOffre" class="form-control"></textarea>
        </div>
        <div class="form-group">
          <label for="competenceOffre">Compétences</label>
          <input type="text" name="competenceOffre" id="competenceOffre" class="form-control" value="">
        </div>
        <div class="form-group">
          <label for="dureeOffre">Durée de stage en semaines</label>
          <input type="number" name="dureeOffre" id="dureeOffre" class="form-control" value="" min="1" required>
        </div>
        <div class="form-group">
          <label for="baseOffre">Base de rémunération</label>
          <input type="number" name="baseOffre" id="baseOffre" class="form-control" value="" min="0" required>
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
          <label for="idEnt">Entreprise *</label>
          <select name="id_entreprise" id="id_entreprise" class="form-control" required>
          <option value="">-- Choisir une entreprise --</option>
          <?php foreach ($entreprises as $ent): ?>
          <option value="<?= $ent['id_entreprise'] ?>"><?= htmlspecialchars($ent['nom_entreprise']) ?></option>
          <?php endforeach; ?>
          </select>
        </div>
        <div class="form-group">
          <label for="idMineure">Mineure *</label>
          <select name="id_mineure" id="id_mineure" class="form-control" required>
          <option value="">-- Choisir une mineure --</option>
          <?php foreach ($mineures as $min): ?>
          <option value="<?= $min['id_mineure'] ?>"><?= htmlspecialchars($min['nom_mineure']) ?></option>
          <?php endforeach; ?>
          </select>
        </div>
        <button type="submit" class="btn btn-primary">Créer</button>
      </form>
    </div>
  </section>
  
  <script src="/js/script.js"></script>
  <script src="/js/script-admin.js"></script>
  <script src="../../js/new.js"></script>
</body>
</html>
