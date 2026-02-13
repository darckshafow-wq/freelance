<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - FreelanceFlow</title>
    <link rel="stylesheet" href="/free_lance_p/public/assets/css/global.css">
    <link rel="stylesheet" href="/free_lance_p/public/assets/css/dashboard.css">
    <script src="/free_lance_p/public/assets/js/script.js" defer></script>
</head>
<body>

<!-- Sidebar -->
<?php include __DIR__ . '/../../../includes/sidebar_admin.php'; ?>

<!-- Main Content -->
<main class="main-content">
    <?php include __DIR__ . '/../../../includes/header_admin.php'; ?>

    <div class="content-wrapper">
        <div class="section-header">
            <div class="content-title-area">
                <h1>Tableau de bord</h1>
                <p>Vue d'ensemble de la plateforme et statistiques clés.</p>
            </div>
        </div>

        <!-- Stats Grid -->
        <section class="stats-grid">
            <div class="stat-card">
                <div class="stat-info">
                    <h3>Utilisateurs</h3>
                    <div class="stat-value"><?= $stats['users'] ?></div>
                </div>
                <div class="stat-icon bg-blue">👥</div>
            </div>
            
            <div class="stat-card">
                <div class="stat-info">
                    <h3>Tâches en attente</h3>
                    <div class="stat-value"><?= $stats['pending'] ?></div>
                </div>
                <div class="stat-icon bg-orange">⏳</div>
            </div>

            <div class="stat-card">
                <div class="stat-info">
                    <h3>Projets Actifs</h3>
                    <div class="stat-value">12</div> <!-- Static for now, can be dynamic -->
                </div>
                <div class="stat-icon bg-green">🚀</div>
            </div>

             <div class="stat-card">
                <div class="stat-info">
                    <h3>Signalements</h3>
                    <div class="stat-value">0</div>
                </div>
                <div class="stat-icon bg-purple">🚩</div>
            </div>
        </section>

        <!-- Charts -->
        <section class="charts-grid">
            <div class="chart-card">
                <div class="chart-header">
                    <h3>Activité de la plateforme</h3>
                </div>
                <canvas id="activityChart"></canvas>
            </div>
        </section>

        <!-- Recent Tasks Table -->
        <section class="table-card">
            <div class="table-header">
                <h3>Dernières tâches en attente</h3>
                <a href="index.php?page=ad_aprobation" class="btn btn-primary" style="padding:0.5rem 1rem; font-size:0.9rem;">Tout voir</a>
            </div>
            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>Titre</th>
                            <th>Description</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach (array_slice($tasks, 0, 5) as $task): ?>
                        <tr>
                            <td><?= htmlspecialchars($task['title']) ?></td>
                            <td><?= htmlspecialchars(substr($task['description'], 0, 50)) ?>...</td>
                            <td>
                                <a href="index.php?page=validate_task&id=<?= $task['id'] ?>" class="action-btn btn-validate">✔ Valider</a>
                                <a href="index.php?page=delete_task&id=<?= $task['id'] ?>" class="action-btn btn-delete">🗑 Supprimer</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </section>

         <!-- Recent Users Table -->
        <section class="table-card">
            <div class="table-header">
                <h3>Derniers utilisateurs</h3>
                <a href="index.php?page=ad_user" class="btn btn-primary" style="padding:0.5rem 1rem; font-size:0.9rem;">Gérer</a>
            </div>
            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Email</th>
                            <th>Rôle</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach (array_slice($users, 0, 5) as $user): ?>
                        <tr>
                            <td><?= htmlspecialchars($user['name']) ?></td>
                            <td><?= htmlspecialchars($user['email']) ?></td>
                            <td>
                                <span style="padding:2px 8px; border-radius:4px; background:#e0f2fe; color:#0284c7; font-size:0.8rem; font-weight:600;">
                                    <?= htmlspecialchars($user['role']) ?>
                                </span>
                            </td>
                            <td>
                                <a href="index.php?page=edit_user&id=<?= $user['id'] ?>" class="action-btn btn-edit">✏️ Éditer</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </section>

    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('activityChart');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: <?= json_encode($chartLabels) ?>,
            datasets: [{
                label: 'Inscriptions',
                data: <?= json_encode($chartData) ?>,
                borderColor: '#4f46e5',
                backgroundColor: 'rgba(79, 70, 229, 0.1)',
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: { beginAtZero: true, grid: { borderDash: [2, 4] } },
                x: { grid: { display: false } }
            }
        }
    });

    // Mobile Sidebar Toggle Overlay
    const overlay = document.createElement('div');
    overlay.className = 'overlay';
    document.body.appendChild(overlay);
    
    document.querySelector('.toggle-sidebar').addEventListener('click', () => {
        overlay.classList.toggle('active');
    });
    
    overlay.addEventListener('click', () => {
         document.getElementById('sidebar').classList.remove('active');
         overlay.classList.remove('active');
    });
</script>

</body>
</html>