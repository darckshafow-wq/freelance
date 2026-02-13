<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tâches Publiées - Admin FreelanceFlow</title>
    <link rel="stylesheet" href="/free_lance_p/public/assets/css/global.css">
    <link rel="stylesheet" href="/free_lance_p/public/assets/css/dashboard.css">
    <script src="/free_lance_p/public/assets/js/script.js" defer></script>
</head>
<body>

<?php include __DIR__ . '/../../../includes/sidebar_admin.php'; ?>

<main class="main-content">
    <?php include __DIR__ . '/../../../includes/header_admin.php'; ?>

    <div class="content-wrapper">
        <div class="section-header">
            <div class="content-title-area">
                <h1>Tâches Publiées</h1>
                <p>Gestion et suivi de toutes les missions actuellement en ligne.</p>
            </div>
        </div>

        <!-- Stats cards -->
        <section class="stats-grid">
            <div class="stat-card">
                <div class="stat-info">
                    <h3>Total Tâches</h3>
                    <div class="stat-value"><?= $stats['tasks'] ?></div>
                </div>
                <div class="stat-icon bg-blue">📋</div>
            </div>
            <div class="stat-card">
                <div class="stat-info">
                    <h3>Publiées</h3>
                    <div class="stat-value"><?= $stats['published'] ?></div>
                </div>
                <div class="stat-icon bg-green">✅</div>
            </div>
            <div class="stat-card">
                <div class="stat-info">
                    <h3>En attente</h3>
                    <div class="stat-value"><?= $stats['pending'] ?></div>
                </div>
                <div class="stat-icon bg-orange">⏳</div>
            </div>
            <div class="stat-card">
                <div class="stat-info">
                    <h3>Validées</h3>
                    <div class="stat-value"><?= $stats['validated'] ?></div>
                </div>
                <div class="stat-icon bg-purple">🏆</div>
            </div>
        </section>

        <!-- Tasks table -->
        <section class="table-card">
            <?php if (!empty($tasks)): ?>
                <div class="table-responsive">
                    <table>
                        <thead>
                            <tr>
                                <th>Détails de la tâche</th>
                                <th>Client</th>
                                <th>Budget</th>
                                <th>Statut</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($tasks as $task): ?>
                                <tr>
                                    <td>
                                        <strong><?= htmlspecialchars($task['title']) ?></strong><br>
                                        <small style="color:var(--text-light);">ID: #<?= $task['id'] ?> • <?= $task['created_at'] ?></small>
                                    </td>
                                    <td>
                                        <div style="display:flex; align-items:center; gap:0.5rem;">
                                             <div class="avatar" style="width:28px; height:28px; font-size:0.8rem; background:var(--secondary-color);">C</div>
                                             <?= htmlspecialchars($task['user_id']) ?>
                                        </div>
                                    </td>
                                    <td>
                                        <span style="font-weight:600; color:var(--text-dark);">$<?= htmlspecialchars($task['price']) ?></span>
                                    </td>
                                    <td>
                                        <span style="padding:2px 8px; border-radius:4px; background:#dcfce7; color:#16a34a; font-size:0.85rem; font-weight:600;">
                                            <?= htmlspecialchars($task['status']) ?>
                                        </span>
                                    </td>
                                    <td>
                                         <a href="#" class="action-btn btn-edit">👁️ Voir</a>
                                         <a href="index.php?page=delete_task&id=<?= $task['id'] ?>" class="action-btn btn-delete">🗑️</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div style="padding:2rem; text-align:center; color:#94a3b8;">Aucune tâche publiée pour le moment.</div>
            <?php endif; ?>
        </section>

    </div>
</main>

</body>
</html>