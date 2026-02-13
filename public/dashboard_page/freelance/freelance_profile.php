<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mon Profil Freelance - FreelanceFlow</title>
    <link rel="stylesheet" href="/free_lance_p/public/assets/css/global.css">
    <link rel="stylesheet" href="/free_lance_p/public/assets/css/dashboard.css">
    <script src="/free_lance_p/public/assets/js/script.js" defer></script>
</head>
<body>
    <?php include __DIR__ . '/../../../includes/sidebar_freelance.php'; ?>

    <main class="main-content">
        <?php include __DIR__ . '/../../../includes/header_freelance.php'; ?>

        <div class="content-wrapper">
            <div class="section-header">
                <div class="content-title-area">
                    <h1>Mon Profil</h1>
                    <p>Mettez à jour vos informations personnelles et professionnelles.</p>
                </div>
            </div>
            
            <div class="detail-content-grid">
                <div class="main-info">
                    <section class="info-section">
                        <h2>Informations Générales</h2>
                        <form class="premium-form">
                            <div class="form-group">
                                <label>Nom Complet</label>
                                <input type="text" value="<?= htmlspecialchars($_SESSION['user']['name']) ?>">
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" value="<?= htmlspecialchars($_SESSION['user']['email']) ?>" disabled>
                            </div>
                            <div class="form-group">
                                <label>Bio Professionnelle</label>
                                <textarea rows="4">Développeur full-stack passionné par les technologies web et les solutions innovantes.</textarea>
                            </div>
                            <button class="btn btn-primary">Enregistrer les modifications</button>
                        </form>
                    </section>
                </div>

                <div class="sidebar-info">
                    <div class="stats-card-premium">
                        <div class="stat-item">
                            <div class="icon">🏆</div>
                            <div class="stat-detail">
                                <label>Badges</label>
                                <p>Freelance Vérifié</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>
</html>
