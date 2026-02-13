<!-- Sidebar -->
<aside class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <a href="index.php?page=admin" class="brand">
            <span class="icon">💠</span>
            <span>FreeFlow</span>
        </a>
    </div>
    
    <nav class="sidebar-nav">
        <a href="index.php?page=dashboard" class="nav-link <?= (!isset($_GET['page']) || $_GET['page'] === 'dashboard' || $_GET['page'] === 'admin') ? 'active' : '' ?>">
            <span class="icon">📊</span> Tableau de bord
        </a>
        <a href="index.php?page=ad_user" class="nav-link <?= ($page === 'ad_user') ? 'active' : '' ?>">
            <span class="icon">👥</span> Utilisateurs
        </a>
        <a href="index.php?page=ad_aprobation" class="nav-link <?= ($page === 'ad_aprobation') ? 'active' : '' ?>">
            <span class="icon">📝</span> Tâches en attente
            <?php if(isset($stats['pending']) && $stats['pending'] > 0): ?>
                <span style="margin-left:auto; background:var(--primary-color); color:white; padding:2px 6px; border-radius:4px; font-size:0.7rem;"><?= $stats['pending'] ?></span>
            <?php endif; ?>
        </a>
        <a href="index.php?page=ad_tasks" class="nav-link <?= ($page === 'ad_tasks') ? 'active' : '' ?>">
            <span class="icon">📂</span> Tâches publiées
        </a>
        <a href="index.php?page=logs" class="nav-link <?= ($page === 'logs') ? 'active' : '' ?>">
            <span class="icon">📜</span> Logs
        </a>
    </nav>

    <div class="sidebar-footer">
        <a href="index.php?page=settings" class="nav-link">
            <span class="icon">⚙️</span> Paramètres
        </a>
        <a href="index.php?page=tasks_list" class="nav-link">
            <span class="icon">🏠</span> Page Générale
        </a>
        <a href="index.php?page=logout" class="nav-link" style="color:#ef4444;">
            <span class="icon">🚪</span> Déconnexion
        </a>
    </div>
</aside>
