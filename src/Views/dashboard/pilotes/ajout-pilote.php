<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Dashboard - Administration - Ajout Pilote</title>
  <link rel="stylesheet" href="../../css/style-admin.css">
  <link rel="icon" type="image/png" href="../../img/icon.png">
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
      <h1 class="grand-titre">Nouveau pilote</h1>

      <?php if (!empty($erreur)) : ?>
        <div class="alert alert-danger"><?= htmlspecialchars($erreur) ?></div>
      <?php endif; ?>

      <form action="index.php?module=pilotes&action=store" method="post" class="verif">
        <div class="form-group">
          <label for="nom">Nom :</label>
          <input type="text" name="nom" id="nom" class="form-control" required>
        </div>

        <div class="form-group">
          <label for="prenom">Prénom :</label>
          <input type="text" name="prenom" id="prenom" class="form-control" required>
        </div>

        <div class="form-group">
          <label for="login">Nom d'utilisateur :</label>
          <input type="text" name="login" id="login" class="form-control" required>
        </div>

        <div class="form-group">
          <label for="mot_de_passe">Mot de passe :</label>
          <input type="password" name="mot_de_passe" id="mot_de_passe" class="form-control" required>
        </div>

        <div class="form-group">
          <label for="adresse">Adresse :</label>
          <input type="text" name="adresse" id="adresse" class="form-control" required>
        </div>

        <div class="form-group">
          <label for="id_ville">Ville :</label>
          <select name="id_ville" id="id_ville" class="form-control" required>
            <option value="">Sélectionnez une ville</option>
            <?php foreach ($villes as $ville): ?>
              <option value="<?= $ville['id_ville'] ?>">
                <?= htmlspecialchars($ville['nom_ville']) ?> (<?= htmlspecialchars($ville['zipcode']) ?>)
              </option>
            <?php endforeach; ?>
          </select>
        </div>

        <button type="submit" class="btn btn-primary">Ajouter</button>
      </form>
    </div>
  </section>

  <script src="../../js/script.js"></script>
  <script src="../../js/script-admin.js"></script>
</body>
</html>
