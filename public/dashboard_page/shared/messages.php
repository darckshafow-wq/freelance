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
</head>
<body>
    <?php 
    session_start();
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
            
            <div class="table-card" style="padding: 4rem; text-align: center; color: var(--text-light);">
                <div style="font-size: 3rem; margin-bottom: 1rem;">💬</div>
                <h3>Votre messagerie arrive bientôt</h3>
                <p>Nous finalisons le système de chat en temps réel pour une meilleure collaboration.</p>
            </div>
        </div>
    </main>
</body>
</html>
