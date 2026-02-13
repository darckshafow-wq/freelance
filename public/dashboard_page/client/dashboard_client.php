<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Espace Client - FreelanceFlow</title>
    <link rel="stylesheet" href="/free_lance_p/public/assets/css/global.css">
    <link rel="stylesheet" href="/free_lance_p/public/assets/css/dashboard.css">
    <script src="/free_lance_p/public/assets/js/script.js" defer></script>
</head>
<body>

<?php include __DIR__ . '/../../../includes/sidebar_client.php'; ?>

<main class="main-content">
    <?php include __DIR__ . '/../../../includes/header_client.php'; ?>

    <div class="content-wrapper">
        <div class="section-header">
            <div class="content-title-area">
                <h1>Mon Espace Client</h1>
                <p>Gérez vos missions et vos collaborations.</p>
            </div>
            <a href="index.php?page=create_task" class="btn btn-primary">➕ Publier une mission</a>
        </div>

        <!-- Stats cards -->
        <section class="stats-grid">
            <div class="stat-card">
                <div class="stat-info">
                    <h3>Missions Publiées</h3>
                    <div class="stat-value">3</div>
                </div>
                <div class="stat-icon bg-blue">📢</div>
            </div>
            <div class="stat-card">
                <div class="stat-info">
                    <h3>Projets en cours</h3>
                    <div class="stat-value">1</div>
                </div>
                <div class="stat-icon bg-orange">🔥</div>
            </div>
            <div class="stat-card">
                <div class="stat-info">
                    <h3>Dépenses (Mois)</h3>
                    <div class="stat-value">1 200 €</div>
                </div>
                <div class="stat-icon bg-green">💳</div>
            </div>
        </section>

        <!-- Current Projects Table -->
        <section class="table-card">
            <div class="table-header">
                <h3>Mes Projets Récents</h3>
                <a href="index.php?page=my_tasks" class="btn btn-edit" style="font-size:0.9rem;">Voir tout</a>
            </div>
            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>Projet</th>
                            <th>Budget</th>
                            <th>Statut</th>
                            <th>Freelance</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Placeholder Data -->
                        <tr>
                            <td>
                                <strong>Refonte site E-commerce</strong><br>
                                <small style="color:var(--text-light);">Publié le 10/02/2026</small>
                            </td>
                            <td><span style="font-weight:600;">2 500 €</span></td>
                            <td><span style="padding:2px 8px; border-radius:4px; background:#dcfce7; color:#16a34a; font-size:0.85rem; font-weight:600;">En cours</span></td>
                            <td>
                                <div style="display:flex; align-items:center; gap:0.5rem;">
                                    <div class="avatar" style="width:24px; height:24px; font-size:0.7rem;">J</div>
                                    Jean D.
                                </div>
                            </td>
                            <td>
                                <a href="#" class="action-btn btn-edit">💬 Message</a>
                                <a href="#" class="action-btn btn-validate">✅ Valider livrable</a>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Logo Startup Tech</strong><br>
                                <small style="color:var(--text-light);">Publié le 08/02/2026</small>
                            </td>
                            <td><span style="font-weight:600;">400 €</span></td>
                            <td><span style="padding:2px 8px; border-radius:4px; background:#ffedd5; color:#c2410c; font-size:0.85rem; font-weight:600;">En attente</span></td>
                            <td>-</td>
                            <td>
                                <a href="#" class="action-btn btn-edit">✏️ Modifier</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>

    </div>
</main>

</body>
</html>
