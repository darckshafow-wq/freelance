<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FreelanceFlow - La plateforme des talents</title>
    <link rel="stylesheet" href="/free_lance_p/public/assets/css/global.css">
    <link rel="stylesheet" href="/free_lance_p/public/assets/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
</head>
<body>

<nav class="navbar dashboard-header-public">
    <div class="header-left">
        <button class="sidebar-toggle-btn public-sidebar-toggle" id="headerSidebarToggle" title="Menu" style="display: none;">
            <span class="icon">☰</span>
        </button>
        <h2 class="explorer-title">Missions Explorer</h2>
    </div>
    
    <script>
        // Only show the toggle if a sidebar exists on the page
        document.addEventListener('DOMContentLoaded', () => {
            if (document.getElementById('sidebar')) {
                const toggle = document.querySelector('.public-sidebar-toggle');
                if (toggle) toggle.style.display = 'flex';
            }
        });
    </script>
    
    <div class="nav-links">
        <a href="index.php?page=welcome">Accueil</a>
        <a href="index.php?page=tasks_list" class="active">Explorer</a>
        
        <?php if (isset($_SESSION['user'])): ?>
            <?php 
                $dashboardLink = 'index.php?page=welcome';
                if ($_SESSION['user']['role'] === 'admin') $dashboardLink = 'index.php?page=admin';
                elseif ($_SESSION['user']['role'] === 'client') $dashboardLink = 'index.php?page=client_dashboard';
                elseif ($_SESSION['user']['role'] === 'freelance') $dashboardLink = 'index.php?page=freelance_dashboard';
            ?>
            <a href="<?= $dashboardLink ?>" class="btn-cta">Tableau de bord</a>
        <?php else: ?>
            <a href="index.php?page=login" class="login-nav">Connexion</a>
            <a href="index.php?page=register" class="btn-cta btn-primary-premium" style="padding: 0.8rem 1.5rem; border-radius: 12px;">S'inscrire</a>
        <?php endif; ?>
    </div>
</nav>
