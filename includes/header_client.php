<!-- Dashboard Header Client -->
    <div class="header-left">
        <button class="sidebar-toggle-btn" id="headerSidebarToggle" title="Menu">
            <span class="icon">☰</span>
        </button>
    </div>
    
    <div class="search-container">
        <input type="text" class="search-input" placeholder="Rechercher un freelance...">
    </div>

    <div class="header-right">
        <div class="notification-btn">
            <span class="icon">🔔</span>
        </div>
        
        <div class="avatar-container">
            <div class="user-info" style="display: block;">
                <span class="user-name"><?= htmlspecialchars($_SESSION['user']['name'] ?? 'Client') ?></span>
                <span class="user-role" style="text-transform: uppercase; font-size: 0.7rem; font-weight: 700; color: #94a3b8;">Client Premium</span>
            </div>
            <div class="avatar">
                <img src="https://ui-avatars.com/api/?name=<?= urlencode($_SESSION['user']['name'] ?? 'C') ?>&background=4f46e5&color=fff" alt="Avatar">
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
