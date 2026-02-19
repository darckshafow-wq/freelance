<?php
// Simple placeholder for Messages
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Messages - FreelanceFlow</title>
    <link rel="stylesheet" href="/free_lance_p/public/assets/css/global.css">
    <link rel="stylesheet" href="/free_lance_p/public/assets/css/dashboard.css">
    <style>
        .conversation-list {
            display: flex;
            flex-direction: column;
            gap: 15px;
            margin-top: 20px;
        }
        .conversation-card {
            background: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            display: flex;
            justify-content: space-between;
            align-items: center;
            text-decoration: none;
            color: inherit;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .conversation-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        .conv-info h3 {
            margin: 0 0 5px 0;
            color: var(--text-dark);
        }
        .conv-info p {
            margin: 0;
            color: var(--text-light);
            font-size: 0.9rem;
        }
        .conv-meta {
            text-align: right;
        }
        .last-msg-date {
            font-size: 0.8rem;
            color: var(--text-light);
            display: block;
            margin-bottom: 8px;
        }
        .preview-text {
            display: block;
            max-width: 300px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            color: #64748b;
            font-size: 0.85rem;
        }
    </style>
</head>
<body>
    <?php 
    $role = $_SESSION['user']['role'] ?? 'public';
    if ($role === 'admin') include __DIR__ . '/../../../includes/sidebar_admin.php';
    elseif ($role === 'client') include __DIR__ . '/../../../includes/sidebar_client.php';
    elseif ($role === 'freelance') include __DIR__ . '/../../../includes/sidebar_freelance.php';
    ?>

    <main class="main-content">
        <?php 
        if ($role === 'admin') include __DIR__ . '/../../../includes/header_admin.php';
        elseif ($role === 'client') include __DIR__ . '/../../../includes/header_client.php';
        else include __DIR__ . '/../../../includes/header_freelance.php';
        ?>

        <div class="content-wrapper">
            <div class="section-header">
                <div class="content-title-area">
                    <h1>Messagerie</h1>
                    <p>Vos conversations avec les clients et freelances.</p>
                </div>
            </div>
            
            <?php if (!empty($conversations)): ?>
                <div class="conversation-list">
                    <?php foreach ($conversations as $conv): ?>
                        <?php 
                            $otherUserId = ($conv['sender_id'] == $_SESSION['user']['id']) ? $conv['receiver_id'] : $conv['sender_id'];
                        ?>
                        <a href="index.php?page=conversation&task_id=<?php echo $conv['task_id']; ?>&receiver_id=<?php echo $otherUserId; ?>" class="conversation-card">
                            <div class="conv-info">
                                <h3><?php echo htmlspecialchars($conv['other_user_name']); ?></h3>
                                <p><strong>Mission:</strong> <?php echo htmlspecialchars($conv['task_title']); ?></p>
                                <span class="preview-text"><?php echo htmlspecialchars($conv['content']); ?></span>
                            </div>
                            <div class="conv-meta">
                                <span class="last-msg-date"><?php echo date('d/m H:i', strtotime($conv['created_at'])); ?></span>
                                <span class="btn btn-primary" style="padding: 5px 15px; font-size: 0.8rem;">Ouvrir</span>
                            </div>
                        </a>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="table-card" style="padding: 4rem; text-align: center; color: var(--text-light);">
                    <div style="font-size: 3rem; margin-bottom: 1rem;">💬</div>
                    <h3>Aucune conversation</h3>
                    <p>Commencez une conversation en contactant un utilisateur depuis ses candidatures ou ses missions.</p>
                </div>
            <?php endif; ?>
        </div>
    </main>
</body>
</html>
