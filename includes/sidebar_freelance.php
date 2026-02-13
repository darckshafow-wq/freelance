<!-- Sidebar Freelance - Premium SaaS -->
<aside class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <a href="index.php?page=freelance_dashboard" class="brand">
            <span class="icon">💠</span>
            <span>FreeFlow</span>
        </a>
    </div>
    
    <nav class="sidebar-nav">
        <a href="index.php?page=dashboard" class="nav-link <?= (!isset($_GET['page']) || $_GET['page'] === 'dashboard' || $_GET['page'] === 'freelance_dashboard') ? 'active' : '' ?>">
            <span class="icon">⊞</span> Tableau de bord
        </a>
        <a href="index.php?page=tasks_list" class="nav-link <?= (isset($_GET['page']) && $_GET['page'] === 'tasks_list') ? 'active' : '' ?>">
            <span class="icon">🔍</span> Missions
        </a>
        <a href="index.php?page=messages" class="nav-link <?= (isset($_GET['page']) && $_GET['page'] === 'messages') ? 'active' : '' ?>">
            <span class="icon">💬</span> Messages
        </a>
        <a href="index.php?page=settings" class="nav-link <?= (isset($_GET['page']) && $_GET['page'] === 'settings') ? 'active' : '' ?>">
            <span class="icon">⚙️</span> Paramètres
        </a>
    </nav>

    <div class="sidebar-footer">
        <a href="index.php?page=tasks_list" class="nav-link">
            <span class="icon">🔍</span> Explorer les missions
        </a>
        <a href="index.php?page=support" class="nav-link">
            <span class="icon">❓</span> Support
        </a>
        <a href="index.php?page=logout" class="nav-link" style="color:#f87171;">
            <span class="icon">↳</span> Déconnexion
        </a>
    </div>
</aside>
