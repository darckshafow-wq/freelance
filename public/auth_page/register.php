<?php include __DIR__ . '/../../includes/header.php'; ?>
<link rel="stylesheet" href="/free_lance_p/public/assets/css/landig.css">
<body>
  <div class="intro-container">
    <!-- Partie gauche -->
    <div class="intro-left">
      <div class="content-wrapper">
        <h1 class="brand">FreelanceFlow</h1>
        <h2>Rejoignez la communauté des meilleurs talents</h2>
        <p class="testimonial">
          Collaborez avec des experts du monde entier ou trouvez votre prochaine mission stratégique en quelques clics.
        </p>
        <img src="/free_lance_p/public/assets/images/workspace.png" alt="Illustration collaborative" class="illustration">
      </div>
    </div>

    <!-- Partie droite : formulaire -->
    <div class="intro-right">
      <form class="registration-form" method="POST" action="index.php?page=register">
        <h1>Commencez l’aventure</h1>
        <p class="login-link">Déjà inscrit ? <a href="index.php?page=login">Se connecter</a></p>

        <div class="form-group">
          <label for="role">Rôle</label>
          <div class="select-wrapper">
            <select name="role" id="role" required>
              <option value="client">Client</option>
              <option value="freelance">Freelance</option>
              <option value="admin">Admin</option>
            </select>
          </div>
        </div>

        <div class="form-group">
          <label for="name">Nom complet</label>
          <input type="text" id="name" name="name" placeholder="Entrez votre nom complet" class="form-input" required>
        </div>

        <div class="form-group">
          <label for="email">Adresse email</label>
          <input type="email" id="email" name="email" placeholder="Entrez votre email" class="form-input" autocomplete="off" required>
        </div>

        <div class="form-group">
          <label for="password">Mot de passe</label>
          <input type="password" id="password" name="password" placeholder="Minimum 8 caractères" class="form-input" autocomplete="off" required>
        </div>

        <button type="submit" class="btn btn-primary btn-block">Créer mon compte</button>

        <div class="social-login">
          <p>Ou continuez avec</p>
          <div class="social-buttons">
            <a href="#" class="btn-google">Google</a>
            <a href="#" class="btn-linkedin">LinkedIn</a>
          </div>
        </div>

        <p class="terms">
          En cliquant sur <strong>Créer mon compte</strong>, vous acceptez nos 
          <a href="#">Conditions d’Utilisation</a> et notre 
          <a href="#">Politique de Confidentialité</a>.
        </p>
      </form>
    </div>
  </div>

  
</body>