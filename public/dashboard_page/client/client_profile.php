<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Profil - FreelanceFlow</title>
    <link rel="stylesheet" href="/free_lance_p/public/assets/css/global.css">
    <link rel="stylesheet" href="/free_lance_p/public/assets/css/dashboard.css">
    <script src="/free_lance_p/public/assets/js/script.js" defer></script>
</head>
<body>

<?php include __DIR__ . '/../../includes/sidebar_client.php'; ?>

<main class="main-content">
    <?php include __DIR__ . '/../../includes/header_client.php'; ?>

    <div class="content-wrapper">
        <div class="detail-content-grid">
            <div class="main-info">
                <section class="info-section">
                    <h2>Informations de l'entreprise</h2>
                    <form class="premium-form">
                        <div class="form-group">
                            <label>Nom ou Raison Sociale</label>
                            <input type="text" value="<?= htmlspecialchars($_SESSION['user']['name']) ?>">
                        </div>
                        <div class="form-group">
                            <label>Email de contact</label>
                            <input type="email" value="<?= htmlspecialchars($_SESSION['user']['email']) ?>" disabled>
                        </div>
                        <div class="form-group">
                            <label>Description de l'activité</label>
                            <textarea rows="4">Entreprise innovante à la recherche de talents exceptionnels pour transformer nos idées en réalité.</textarea>
                        </div>
                        <button class="btn btn-primary">Mettre à jour le profil</button>
                    </form>
                </section>
            </div>

            <div class="sidebar-info">
                <div class="stats-card-premium">
                    <div class="stat-item">
                        <div class="icon">🏢</div>
                        <div class="stat-detail">
                            <label>Type de compte</label>
                            <p>Client Privilège</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</main>

</body>
</html>
