<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Espace Freelance - FreelanceFlow</title>
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
            <h1>Mon Dashboard</h1>
            <p>Suivez vos performances et vos missions en cours.</p>
        </div>
        <a href="index.php?page=tasks_list" class="btn btn-primary" style="display: flex; align-items: center; gap: 0.5rem; border-radius: 12px; padding: 0 1.5rem;">
            🔍 Trouver une mission
        </a>
    </div>

    <!-- Stats cards -->
    <section class="stats-grid">
        <div class="stat-card">
            <div class="stat-info">
                <h3>Candidatures</h3>
                <div class="stat-value">8</div>
            </div>
            <div class="stat-icon bg-blue">📨</div>
        </div>
        <div class="stat-card">
            <div class="stat-info">
                <h3>Missions en cours</h3>
                <div class="stat-value">2</div>
            </div>
            <div class="stat-icon bg-orange">🔥</div>
        </div>
        <div class="stat-card">
            <div class="stat-info">
                <h3>Gains (Mois)</h3>
                <div class="stat-value">2 450 €</div>
            </div>
            <div class="stat-icon bg-green">💰</div>
        </div>
    </section>

    <!-- Current Missions Table -->
    <section class="table-card">
        <div class="table-header">
            <h3>Mes dernières candidatures</h3>
            <a href="index.php?page=my_applications" class="action-btn btn-edit" style="width: auto; padding: 0.5rem 1rem;">Voir tout</a>
        </div>
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Mission</th>
                        <th>Client</th>
                        <th>Budget</th>
                        <th>Statut</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>Développement API REST</strong><br><small style="color:var(--text-light);">Backend / PHP</small></td>
                        <td>TechCorp Inc.</td>
                        <td><span style="font-weight:700;">1 200 €</span></td>
                        <td><span style="padding: 4px 10px; border-radius: 6px; background: #e0f2fe; color: #0284c7; font-size: 0.8rem; font-weight: 700;">En cours</span></td>
                        <td>12/02/2026</td>
                    </tr>
                    <tr>
                        <td><strong>Intégration Figma</strong><br><small style="color:var(--text-light);">Frontend / CSS</small></td>
                        <td>Studio Design</td>
                        <td><span style="font-weight:700;">500 €</span></td>
                        <td><span style="padding: 4px 10px; border-radius: 6px; background: #fee2e2; color: #dc2626; font-size: 0.8rem; font-weight: 700;">Refusé</span></td>
                        <td>10/02/2026</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </section>
</div>
</main>
</body>
</html>
