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
                    <div class="stat-value"><?= htmlspecialchars($stats['candidatures']) ?></div>
                </div>
                <div class="stat-icon bg-blue">📨</div>
            </div>
            <div class="stat-card">
                <div class="stat-info">
                    <h3>Missions en cours</h3>
                    <div class="stat-value"><?= htmlspecialchars($stats['active_tasks']) ?></div>
                </div>
                <div class="stat-icon bg-orange">🔥</div>
            </div>
            <div class="stat-card">
                <div class="stat-info">
                    <h3>Gains (Mois)</h3>
                    <div class="stat-value"><?= htmlspecialchars($stats['monthly_earnings']) ?> €</div>
                </div>
                <div class="stat-icon bg-green">💰</div>
            </div>
        </section>

        <!-- Active Projects Section (New) -->
        <?php
        try {
            require_once __DIR__ . '/../../../app/core/database.php';
            $db = (new Database())->getConnection();
            $stmt = $db->prepare("SELECT DISTINCT t.*, u.name as client_name 
                FROM tasks t 
                JOIN users u ON t.user_id = u.id
                LEFT JOIN application a ON t.id = a.task_id AND a.freelance_id = ? AND a.status = 'accepted'
                LEFT JOIN team_members tm ON t.id = tm.task_id AND tm.user_id = ?
                WHERE (a.id IS NOT NULL OR tm.id IS NOT NULL) AND t.status != 'completed'");
            $stmt->execute([$_SESSION['user']['id'], $_SESSION['user']['id']]);
            $activeProjects = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log("Dashboard query error: " . $e->getMessage());
            $activeProjects = [];
        }
        ?>
        
        <?php if (!empty($activeProjects)): ?>
        <section class="table-card" style="margin-bottom: 30px;">
            <div class="table-header">
                <h3>🚀 Mes projets en cours</h3>
            </div>
            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>Mission</th>
                            <th>Client</th>
                            <th>Budget</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($activeProjects as $p): ?>
                        <tr>
                            <td><strong><?= htmlspecialchars($p['title']) ?></strong></td>
                            <td><?= htmlspecialchars($p['client_name']) ?></td>
                            <td><span style="font-weight:700;"><?= number_format($p['price'], 0, ',', ' ') ?> €</span></td>
                            <td>
                                <a href="index.php?page=collaboration&id=<?= $p['id'] ?>" class="btn-hub-highlight" style="font-size:0.85rem;">
                                    <span>🚀</span> Accéder au Hub
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </section>
        <?php endif; ?>

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
                        <?php if (!empty($stats['recent_applications'])): ?>
                            <?php foreach ($stats['recent_applications'] as $app): ?>
                                <tr>
                                    <td>
                                        <strong><?= htmlspecialchars($app['title']) ?></strong><br>
                                        <small style="color:var(--text-light);"><?= htmlspecialchars($app['domain'] ?? '') ?></small>
                                    </td>
                                    <td><?= htmlspecialchars($app['client_name'] ?? 'N/A') ?></td>
                                    <td><span style="font-weight:700;"><?= htmlspecialchars($app['price']) ?> €</span></td>
                                    <td>
                                        <?php
                                        $status = $app['status'];
                                        $classes = [
                                            'pending'     => 'background:#fef9c3;color:#ca8a04;',
                                            'accepted'    => 'background:#dcfce7;color:#16a34a;',
                                            'rejected'    => 'background:#fee2e2;color:#dc2626;',
                                            'in_progress' => 'background:#e0f2fe;color:#0284c7;',
                                            'team'        => 'background:#f5f3ff;color:#7c3aed;'
                                        ];
                                        ?>
                                        <span style="padding:4px 10px;border-radius:6px;font-size:0.8rem;font-weight:700;<?= $classes[$status] ?? '' ?>">
                                            <?= $status === 'team' ? 'Équipe 👥' : ucfirst($status) ?>
                                        </span>
                                    </td>
                                    <td><?= date('d/m/Y', strtotime($app['created_at'])) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" style="text-align:center; color:#777;">Aucune candidature récente</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </section>
    </div>
</main>
</body>
</html>