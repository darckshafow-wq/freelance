<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Candidatures Reçues - FreelanceFlow</title>
    <link rel="stylesheet" href="/free_lance_p/public/assets/css/global.css">
    <link rel="stylesheet" href="/free_lance_p/public/assets/css/dashboard.css">
    <script src="/free_lance_p/public/assets/js/script.js" defer></script>
</head>
<body>

<?php include __DIR__ . '/../../../includes/sidebar_client.php'; ?>

<main class="main-content">
    <?php include __DIR__ . '/../../../includes/header_client.php'; ?>

    <div class="content-wrapper">
        <h1 class="page-title">Candidatures Reçues</h1>

        <div class="card">
            <?php if (!empty($applications)): ?>
                <div class="table-responsive">
                    <table>
                        <thead>
                            <tr>
                                <th>Freelance</th>
                                <th>Mission</th>
                                <th>Offre</th>
                                <th>Message</th>
                                <th>Date</th>
                                <th>Statut</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($applications as $app): ?>
                                <tr>
                                    <td>
                                        <strong><?= htmlspecialchars($app['freelance_name']) ?></strong><br>
                                        <span style="font-size:0.85rem; color:var(--text-light);"><?= htmlspecialchars($app['freelance_email']) ?></span>
                                    </td>
                                    <td>
                                        <a href="index.php?page=task_detail&id=<?= $app['task_id'] ?>" style="color:var(--primary-color); text-decoration:none;">
                                            <?= htmlspecialchars($app['task_title']) ?>
                                        </a>
                                    </td>
                                    <td><span style="font-weight:600;"><?= number_format($app['bid_price'], 0, ',', ' ') ?> €</span></td>
                                    <td>
                                        <button class="btn" style="padding:4px 8px; font-size:0.8rem; background:#f3f4f6;" onclick="alert('Message: <?= addslashes(htmlspecialchars($app['message'])) ?>')">Voir msg</button>
                                    </td>
                                    <td><?= date('d/m/Y', strtotime($app['created_at'])) ?></td>
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
                                    <td>
                                        <?php if ($app['status'] === 'pending'): ?>
                                            <div style="display:flex; gap:5px;">
                                                <form method="POST" action="index.php?page=update_application_status" style="display:inline;">
                                                    <input type="hidden" name="application_id" value="<?= $app['id'] ?>">
                                                    <input type="hidden" name="status" value="accepted">
                                                    <button type="submit" class="btn" style="background:#16a34a; color:white; padding:6px 10px; font-size:0.8rem;">✔ Accepter</button>
                                                </form>
                                                <form method="POST" action="index.php?page=update_application_status" style="display:inline;">
                                                    <input type="hidden" name="application_id" value="<?= $app['id'] ?>">
                                                    <input type="hidden" name="status" value="rejected">
                                                    <button type="submit" class="btn" style="background:#dc2626; color:white; padding:6px 10px; font-size:0.8rem;">✖ user</button>
                                                </form>
                                            </div>
                                        <?php else: ?>
                                            <span style="color:var(--text-light); font-size:0.85rem;">Traité</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div style="text-align:center; padding:3rem;">
                    <p style="color:var(--text-light); font-size:1.1rem; margin-bottom:1rem;">Aucune candidature reçue pour le moment.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</main>

</body>
</html>
