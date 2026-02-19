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

        <!-- Current Projects Table -->
        <?php
        try {
            require_once __DIR__ . '/../../../app/core/database.php';
            $db = (new Database())->getConnection();
            $stmt = $db->prepare("SELECT t.*, u.name as freelance_name, a.id as application_id 
                FROM tasks t 
                LEFT JOIN application a ON t.id = a.task_id AND a.status = 'accepted'
                LEFT JOIN users u ON a.freelance_id = u.id
                WHERE t.user_id = ? 
                ORDER BY t.created_at DESC LIMIT 5");
            $stmt->execute([$_SESSION['user']['id']]);
            $recentTasks = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log("Dashboard client query error: " . $e->getMessage());
            $recentTasks = [];
            $db = (new Database())->getConnection(); // Still need connection for other parts
        }

        // Stats counts
        $taskModel = new Tasks($db);
        $totalPublished = $taskModel->countPublishedTasks();
        $totalInProgress = $db->prepare("SELECT COUNT(*) FROM tasks WHERE user_id = ? AND status = 'in_progress'");
        $totalInProgress->execute([$_SESSION['user']['id']]);
        $countInProgress = $totalInProgress->fetchColumn();
        ?>
        
        <section class="stats-grid">
            <div class="stat-card">
                <div class="stat-info">
                    <h3>Missions Publiées</h3>
                    <div class="stat-value"><?= $totalPublished ?></div>
                </div>
                <div class="stat-icon bg-blue">📢</div>
            </div>
            <div class="stat-card">
                <div class="stat-info">
                    <h3>Projets en cours</h3>
                    <div class="stat-value"><?= $countInProgress ?></div>
                </div>
                <div class="stat-icon bg-orange">🔥</div>
            </div>
            <div class="stat-card">
                <div class="stat-info">
                    <h3>Dépenses (Mois)</h3>
                    <div class="stat-value">0 €</div>
                </div>
                <div class="stat-icon bg-green">💳</div>
            </div>
        </section>

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
                        <?php if (empty($recentTasks)): ?>
                            <tr><td colspan="5" style="text-align:center; padding:20px; color:#64748b;">Aucune mission pour le moment.</td></tr>
                        <?php else: ?>
                            <?php foreach ($recentTasks as $rt): ?>
                            <tr>
                                <td>
                                    <strong><?= htmlspecialchars($rt['title']) ?></strong><br>
                                    <small style="color:var(--text-light);">Posté le <?= date('d/m/Y', strtotime($rt['created_at'])) ?></small>
                                </td>
                                <td><span style="font-weight:600;"><?= number_format($rt['price'], 0, ',', ' ') ?> €</span></td>
                                <td>
                                    <?php 
                                    $statusLabels = [
                                        'pending' => ['En attente', '#ffedd5', '#c2410c'],
                                        'published' => ['Publiée', '#dbeafe', '#2563eb'],
                                        'in_progress' => ['En cours', '#dcfce7', '#16a34a'],
                                        'completed' => ['Terminée', '#f1f5f9', '#475569']
                                    ];
                                    $s = $statusLabels[$rt['status']] ?? ['Inconnu', '#eee', '#666'];
                                    ?>
                                    <span style="padding:2px 8px; border-radius:4px; background:<?= $s[1] ?>; color:<?= $s[2] ?>; font-size:0.85rem; font-weight:600;">
                                        <?= $s[0] ?>
                                    </span>
                                </td>
                                <td><?= htmlspecialchars($rt['freelance_name'] ?? '-') ?></td>
                                <td class="actions-cell">
                                    <div class="action-group">
                                        <?php if ($rt['status'] === 'in_progress'): ?>
                                            <a href="index.php?page=collaboration&id=<?= $rt['id'] ?>" class="btn-hub-highlight">
                                                <span>🚀</span> Hub Travail
                                            </a>
                                        <?php elseif ($rt['status'] === 'published'): ?>
                                            <a href="index.php?page=view_applications&task_id=<?= $rt['id'] ?>" class="action-btn btn-edit">👥 Candidatures</a>
                                        <?php else: ?>
                                            <a href="index.php?page=edit_task&id=<?= $rt['id'] ?>" class="action-btn btn-edit">✏️ Modifier</a>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </section>

    </div>
</main>

</body>
</html>
