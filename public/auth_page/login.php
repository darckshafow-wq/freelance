<?php include __DIR__ . '/../../includes/header.php'; ?>
<link rel="stylesheet" href="/free_lance_p/public/assets/css/login.css">
<?php
if (isset($_SESSION['error'])) {
    echo "<p class='error'>" . $_SESSION['error'] . "</p>";
    unset($_SESSION['error']);
}
if (isset($_SESSION['success'])) {
    echo "<p class='success'>" . $_SESSION['success'] . "</p>";
    unset($_SESSION['success']);
}
?>


<body>
  <div class="login-wrapper">
    <!-- Partie gauche (Visuelle) -->
    <div class="intro-left">
      <div class="content-wrapper">
        <h1 class="brand">FreelanceFlow</h1>
        <h2>Reprenez là où vous vous étiez arrêté</h2>
        <p class="testimonial">
          Accédez à vos missions en cours et collaborez avec les meilleurs experts en temps réel.
        </p>
        <img src="/free_lance_p/public/assets/images/workspace.png" alt="Illustration collaborative" class="illustration">
      </div>
    </div>

    <!-- Partie droite (Formulaire) -->
    <div class="intro-right">
      <div class="login-container">
        <h1>Bon retour !</h1>
        <p class="signup">Pas encore de compte ? <a href="index.php?page=register">S'inscrire</a></p>

        <?php include __DIR__ . '/../../includes/alerts.php'; ?>

        <form method="POST" action="index.php?page=login">
          <div class="form-group">
            <label for="email">Email professionnel</label>
            <input type="email" id="email" name="email" placeholder="nom@entreprise.com" autocomplete="off" required>
          </div>

          <div class="form-group">
            <label for="password">Mot de passe</label>
            <input type="password" id="password" name="password" placeholder="••••••••" autocomplete="off" required>
          </div>

          <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">

          <div class="forgot">
            <a href="index.php?page=forgot">Mot de passe oublié ?</a>
          </div>

          <button type="submit" class="btn-primary">Se connecter</button>
        </form>

        <div class="divider">OU CONTINUER AVEC</div>

        <div class="social-login">
          <div class="social-buttons">
            <a href="#" class="btn-google">Google</a>
            <a href="#" class="btn-linkedin">LinkedIn</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>


