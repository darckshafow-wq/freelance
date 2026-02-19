<!-- Dashboard Header - Premium SaaS -->
<header class="dashboard-header">
    <div class="header-left">
        <button class="sidebar-toggle-btn" id="headerSidebarToggle" title="Menu">
            <span class="icon">☰</span>
        </button>
        <h2 class="explorer-title">Missions Explorer</h2>
    </div>
    
    <div class="search-container">
        <input type="text" class="search-input" placeholder="Rechercher une mission, un talent...">
    </div>

    <div class="header-right">
        <?php
        require_once __DIR__ . '/../app/models/message.php';
        require_once __DIR__ . '/../app/core/database.php';
        $msgModel = new message((new Database())->getConnection());
        $unreadCount = $msgModel->countUnreadMessages($_SESSION['user']['id']);
        ?>
        <a href="index.php?page=messages" class="notification-btn" title="Notification Center" style="position: relative; text-decoration: none; color: inherit;">
            <span class="icon">🔔</span>
            <?php if ($unreadCount > 0): ?>
                <span style="position: absolute; top: -5px; right: -5px; background: #ef4444; color: white; border-radius: 50%; width: 18px; height: 18px; font-size: 0.7rem; display: flex; align-items: center; justify-content: center; border: 2px solid white;">
                    <?= $unreadCount ?>
                </span>
            <?php endif; ?>
        </a>
        
        <div class="avatar-container">
            <div class="user-info" style="display: block;">
                <span class="user-name"><?= htmlspecialchars($_SESSION['user']['name'] ?? 'Alex Durand') ?></span>
                <span class="user-role" style="text-transform: uppercase; font-size: 0.7rem; font-weight: 700; color: #94a3b8;">Freelancer Pro</span>
            </div>
            <div class="avatar">
                <img src="https://ui-avatars.com/api/?name=<?= urlencode($_SESSION['user']['name'] ?? 'AD') ?>&background=0f172a&color=fff" alt="Avatar">
            </div>
        </div>
    </div>
</header>

<?php if (isset($_SESSION['success'])): ?>
    <div class="alert alert-success" style="background:#dcfce7; color:#16a34a; padding:15px; margin:20px; border-radius:8px; border:1px solid #bbf7d0;">
        <?= $_SESSION['success']; unset($_SESSION['success']); ?>
    </div>
<?php endif; ?>

<?php if (isset($_SESSION['error'])): ?>
    <div class="alert alert-error" style="background:#fee2e2; color:#dc2626; padding:15px; margin:20px; border-radius:8px; border:1px solid #fecaca;">
        <?= $_SESSION['error']; unset($_SESSION['error']); ?>
    </div>
<?php endif; ?>
