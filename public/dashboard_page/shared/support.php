<?php
// Simple placeholder for Support
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Support - FreelanceFlow</title>
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
        elseif ($role === 'freelance') include __DIR__ . '/../../../includes/header_freelance.php';
        else include __DIR__ . '/../../../includes/header_public.php';
        ?>

        <div class="content-wrapper">
            <div class="section-header">
                <div class="content-title-area">
                    <h1>Centre d'Aide & Support</h1>
                    <p>Comment pouvons-nous vous aider aujourd'hui ?</p>
                </div>
            </div>
            
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-info">
                        <h3>Base de connaissances</h3>
                        <p>Guides et tutoriels</p>
                    </div>
                    <div class="stat-icon bg-blue">📚</div>
                </div>
                <div class="stat-card">
                    <div class="stat-info">
                        <h3>Ticket de support</h3>
                        <p>Contacter un expert</p>
                    </div>
                    <div class="stat-icon bg-purple">🎫</div>
                </div>
                <div class="stat-card">
                    <div class="stat-info">
                        <h3>Communauté</h3>
                        <p>Forum d'entraide</p>
                    </div>
                    <div class="stat-icon bg-green">👥</div>
                </div>
            </div>

            <div class="table-card" style="padding: 3rem;">
                <h3>Questions Fréquentes</h3>
                <div style="margin-top: 1.5rem; display: flex; flex-direction: column; gap: 1rem;">
                    <details style="padding: 1rem; border: 1px solid #f1f5f9; border-radius: 12px;">
                        <summary style="font-weight: 700; cursor: pointer;">Comment fonctionne le paiement ?</summary>
                        <p style="margin-top: 0.5rem; color: var(--text-light);">Le paiement est sécurisé par un système de séquestre (escrow).</p>
                    </details>
                    <details style="padding: 1rem; border: 1px solid #f1f5f9; border-radius: 12px;">
                        <summary style="font-weight: 700; cursor: pointer;">Comment modifier mon profil ?</summary>
                        <p style="margin-top: 0.5rem; color: var(--text-light);">Allez dans vos paramètres depuis le menu latéral.</p>
                    </details>
                </div>
            </div>
        </div>
    </main>
</body>
</html>
