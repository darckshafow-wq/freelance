<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Utilisateurs - Admin FreelanceFlow</title>
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
                <h1>Utilisateurs</h1>
                <p>Gestion des comptes, des rôles et de la sécurité des membres.</p>
            </div>
            <div class="header-actions">
                <div class="filters">
                    <a href="#" class="btn-filter-toggle">Tous</a>
                    <a href="#" class="btn-filter-toggle">Freelances</a>
                    <a href="#" class="btn-filter-toggle">Clients</a>
                </div>
            </div>
        </div>

        <!-- Stats cards -->
        <section class="stats-grid">
            <div class="stat-card">
                <div class="stat-info">
                    <h3>Total Utilisateurs</h3>
                    <div class="stat-value"><?= $stats['users'] ?></div>
                </div>
                <div class="stat-icon bg-blue">👥</div>
            </div>
            <div class="stat-card">
                <div class="stat-info">
                    <h3>Actifs</h3>
                    <div class="stat-value">1,894</div>
                </div>
                <div class="stat-icon bg-green">🟢</div>
            </div>
            <div class="stat-card">
                <div class="stat-info">
                    <h3>Nouveaux (7j)</h3>
                    <div class="stat-value">452</div>
                </div>
                <div class="stat-icon bg-purple">📈</div>
            </div>
            <div class="stat-card">
                <div class="stat-info">
                    <h3>Signalés</h3>
                    <div class="stat-value">12</div>
                </div>
                <div class="stat-icon bg-orange">⚠️</div>
            </div>
        </section>

        <!-- Users table -->
        <section class="table-card">
            <?php if (!empty($users)): ?>
                <div class="table-responsive">
                    <table>
                        <thead>
                            <tr>
                                <th>Nom</th>
                                <th>Email</th>
                                <th>Rôle</th>
                                <th>Inscrit le</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($users as $user): ?>
                                <tr>
                                    <td>
                                        <div style="display:flex; align-items:center; gap:0.5rem;">
                                            <div class="avatar" style="width:32px; height:32px; font-size:0.9rem;"><?= strtoupper(substr($user['name'],0,1)) ?></div>
                                            <?= htmlspecialchars($user['name']) ?>
                                        </div>
                                    </td>
                                    <td><?= htmlspecialchars($user['email']) ?></td>
                                    <td>
                                        <span style="padding:2px 8px; border-radius:4px; background:#e0f2fe; color:#0284c7; font-size:0.8rem; font-weight:600;">
                                            <?= htmlspecialchars($user['role']) ?>
                                        </span>
                                    </td>
                                    <td><?= htmlspecialchars($user['created_at']) ?></td>
                                    <td>
                                        <a href="index.php?page=edit_user&id=<?= $user['id'] ?>" class="action-btn btn-edit">✏️ Éditer</a>
                                        <a href="index.php?page=delete_user&id=<?= $user['id'] ?>" class="action-btn btn-delete">🗑️ Supprimer</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div style="padding:2rem; text-align:center; color:#94a3b8;">Aucun utilisateur trouvé.</div>
            <?php endif; ?>
        </section>

        <!-- Pagination -->
        <div style="display:flex; justify-content:space-between; align-items:center; margin-top:1.5rem;">
            <span style="color:var(--text-light); font-size:0.9rem;">Affichage de 1 à 10 sur <?= $stats['users'] ?> utilisateurs</span>
            <div style="display:flex; gap:0.5rem;">
                <button class="btn" style="background:white; border:1px solid var(--border-color);">Précédent</button>
                <button class="btn" style="background:white; border:1px solid var(--border-color);">Suivant</button>
            </div>
        </div>

    </div>
</main>

</body>
</html>