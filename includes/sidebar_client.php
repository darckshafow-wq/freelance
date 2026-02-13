<!-- Sidebar Client -->
<aside class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <a href="index.php?page=client_dashboard" class="brand">
            <span class="icon">💠</span>
            <span>FreeFlow</span>
        </a>
    </div>
    
    <nav class="sidebar-nav">
        <a href="index.php?page=dashboard" class="nav-link <?= (!isset($_GET['page']) || $_GET['page'] === 'dashboard' || $_GET['page'] === 'client_dashboard') ? 'active' : '' ?>">
            <span class="icon">📊</span> Tableau de bord
        </a>
        <a href="index.php?page=create_task" class="nav-link <?= (isset($_GET['page']) && $_GET['page'] === 'create_task') ? 'active' : '' ?>">
            <span class="icon">➕</span> Publier une mission
        </a>
        <a href="index.php?page=client_applications" class="nav-link <?= (isset($_GET['page']) && $_GET['page'] === 'client_applications') ? 'active' : '' ?>">
            <span class="icon">📂</span> Candidatures Reçues
        </a>
        <a href="index.php?page=my_tasks" class="nav-link <?= (isset($_GET['page']) && $_GET['page'] === 'my_tasks') ? 'active' : '' ?>">
            <span class="icon">📂</span> Mes projets
        </a>
        <a href="index.php?page=client_profile" class="nav-link <?= (isset($_GET['page']) && $_GET['page'] === 'client_profile') ? 'active' : '' ?>">
            <span class="icon">👤</span> Mon Profil
        </a>
    </nav>

    <div class="sidebar-footer">
        <a href="index.php?page=tasks_list" class="nav-link">
            <span class="icon">🌍</span> Voir le site public
        </a>
        <a href="index.php?page=settings" class="nav-link">
            <span class="icon">⚙️</span> Paramètres
        </a>
        <a href="index.php?page=logout" class="nav-link" style="color:#ef4444;">
            <span class="icon">🚪</span> Déconnexion
        </a>
    </div>
</aside>
