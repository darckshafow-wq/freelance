<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes Candidatures - FreelanceFlow</title>
    <link rel="stylesheet" href="/free_lance_p/public/assets/css/global.css">
    <link rel="stylesheet" href="/free_lance_p/public/assets/css/dashboard.css">
    <script src="/free_lance_p/public/assets/js/script.js" defer></script>
</head>
<body>

<?php include __DIR__ . '/../../../includes/sidebar_freelance.php'; ?>

<main class="main-content">
    <?php include __DIR__ . '/../../../includes/header_freelance.php'; ?>

    <div class="content-wrapper">
        <h1 class="page-title">Mes Candidatures</h1>

        <div class="card">
            <?php if (!empty($applications)): ?>
                <div class="table-responsive">
                    <table>
                        <thead>
                            <tr>
                                <th>Mission</th>
                                <th>Client</th>
                                <th>Mon offre</th>
                                <th>Message</th>
                                <th>Statut</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($applications as $app): ?>
                                <tr>
                                    <td>
                                        <strong><?= htmlspecialchars($app['task_title']) ?></strong>
                                    </td>
                                    <td><?= htmlspecialchars($app['client_name']) ?></td>
                                    <td><span style="font-weight:600;"><?= number_format($app['bid_price'], 0, ',', ' ') ?> €</span></td>
                                    <td>
                                        <button class="btn" style="padding:4px 8px; font-size:0.8rem; background:#f3f4f6;" onclick="alert('Message: <?= addslashes(htmlspecialchars($app['message'])) ?>')">Voir msg</button>
                                    </td>
                                    <td>
                                        <?php
                                            $statusColor = '#e5e7eb';
                                            $statusText = '#374151';
                                            if ($app['status'] === 'accepted') { $statusColor = '#dcfce7'; $statusText = '#16a34a'; }
                                            elseif ($app['status'] === 'rejected') { $statusColor = '#fee2e2'; $statusText = '#dc2626'; }
                                            else { $statusColor = '#e0f2fe'; $statusText = '#0284c7'; }
                                        ?>
                                        <span style="padding:4px 10px; border-radius:15px; background:<?= $statusColor ?>; color:<?= $statusText ?>; font-weight:600; font-size:0.85rem;">
                                            <?= ucfirst($app['status']) ?>
                                        </span>
                                    </td>
                                    <td><?= date('d/m/Y', strtotime($app['created_at'])) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div style="text-align:center; padding:3rem;">
                    <p style="color:var(--text-light); font-size:1.1rem; margin-bottom:1rem;">Vous n'avez pas encore postulé à des missions.</p>
                    <a href="index.php?page=tasks_list" class="btn btn-primary">Trouver une mission</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</main>

</body>
</html>
