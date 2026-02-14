<?php
// public/dashboard_page/shared/notifications.php
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mes Notifications</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <?php include __DIR__ . '/../../../includes/header.php'; ?>
    <div class="content">
        <h1>Mes Notifications</h1>
        <?php if (empty($notifications)): ?>
            <p>Vous n'avez pas de notifications.</p>
        <?php else: ?>
            <ul class="notification-list">
                <?php foreach ($notifications as $notif): ?>
                    <li class="notification-item <?= $notif['is_read'] ? 'read' : 'unread' ?>">
                        <div class="notif-content">
                            <strong><?= htmlspecialchars($notif['type']) ?></strong>
                            <p><?= htmlspecialchars($notif['message']) ?></p>
                            <span><?= $notif['created_at'] ?></span>
                        </div>
                        <?php if (!$notif['is_read']): ?>
                            <a href="index.php?page=notifications&action=mark_read&id=<?= $notif['id'] ?>" class="btn-mark-read">Marquer comme lu</a>
                        <?php endif; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>
</body>
</html>
