<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trouver une mission - FreelanceFlow</title>
    <link rel="stylesheet" href="/free_lance_p/public/assets/css/global.css">
    <link rel="stylesheet" href="/free_lance_p/public/assets/css/dashboard.css">
    <link rel="stylesheet" href="/free_lance_p/public/assets/css/tasks_list.css">
    <script src="/free_lance_p/public/assets/js/script.js" defer></script>
</head>
<body>
    <?php 
    // On affiche la sidebar freelance par défaut pour la liste des missions
    include __DIR__ . '/../../includes/sidebar_freelance.php'; 
    ?>

    <main class="main-content">
        <?php 
        // Header dynamique selon la session
        if (isset($_SESSION['user'])) {
            if ($_SESSION['user']['role'] === 'client') include __DIR__ . '/../../includes/header_client.php';
            elseif ($_SESSION['user']['role'] === 'freelance') include __DIR__ . '/../../includes/header_freelance.php';
            elseif ($_SESSION['user']['role'] === 'admin') include __DIR__ . '/../../includes/header_admin.php';
        } else {
            // Pour les visiteurs, on utilise un header public mais compatible avec la sidebar
            include __DIR__ . '/../../includes/header_public.php';
        }
        ?>
        <div class="content-wrapper">

<div class="tasks-content">
    <div class="section-header">
        <div class="content-title-area">
            <h1>Dernières Missions</h1>
            <p>Découvrez les meilleures opportunités qui correspondent à votre profil d'expert.</p>
        </div>
        <div class="header-actions">
            <button class="btn-filter-toggle">
                <span class="icon">⚙️</span> Filtres
            </button>
            <a href="index.php?page=tasks_fiche" class="btn btn-primary-premium">
                <span class="icon-plus">+</span> Publier une offre
            </a>
        </div>
    </div>

    <div class="filter-group">
        <button class="filter-pill active">Toutes</button>
        <button class="filter-pill"><span></></span> Développement</button>
        <button class="filter-pill"><span>🎨</span> Design</button>
        <button class="filter-pill"><span>📢</span> Marketing</button>
        <button class="filter-pill"><span>✍️</span> Rédaction</button>
    </div>

    <div class="tasks-grid">
        <?php if (!empty($tasks)): ?>
            <?php foreach ($tasks as $task): 
                // Color coding categories if possible, or just random pretty images
                $imgId = (int)$task['id'] % 5 + 1;
                $category = htmlspecialchars($task['category'] ?? 'E-COMMERCE');
                if ($category == 'dev') $category = 'DÉVELOPPEMENT APP';
                if ($category == 'design') $category = 'BRANDING';
                if ($category == 'seo') $category = 'SEO & MARKETING';
            ?>
                <div class="task-card">
                    <div class="task-card-header">
                        <span class="category-badge"><?= $category ?></span>
                        <div class="status-marker <?= $imgId % 2 == 0 ? 'remote' : 'onsite' ?>"></div>
                    </div>
                    <div class="task-card-body">
                        <div class="task-header">
                            <h3 title="<?= htmlspecialchars($task['title']) ?>"><?= htmlspecialchars($task['title']) ?></h3>
                            <div class="task-price">
                                <?= number_format($task['price'], 0, ',', ' ') ?><span> €</span>
                            </div>
                        </div>
                        
                        <div class="task-meta-list">
                            <div class="task-meta-item" title="Localisation">
                                <span class="icon">📍</span> <?= htmlspecialchars($task['localisation'] ?? 'Distance') ?>
                            </div>
                            <div class="task-meta-item" title="Type de travail">
                                <span class="icon">💻</span> <?= $imgId % 2 == 0 ? 'Télétravail' : 'Sur site' ?>
                            </div>
                            <div class="task-meta-item" title="Publié il y a">
                                <span class="icon">🕒</span> <?= rand(1, 10) ?> jours
                            </div>
                        </div>

                        <p class="task-desc"><?= htmlspecialchars(substr($task['description'], 0, 100)) ?>...</p>
                        
                        <div class="task-card-footer">
                            <div class="tags-container">
                                <span class="tag">#Mission</span>
                                <span class="tag">#Expert</span>
                            </div>
                            <a href="index.php?page=task_detail&id=<?= $task['id'] ?>" class="btn-card-more">
                                Détails <span>→</span>
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="empty-tasks-state">
                <div class="empty-icon">📂</div>
                <p class="empty-title">Aucune mission trouvée pour le moment.</p>
                <p class="empty-subtitle">Revenez plus tard ou modifiez vos filtres.</p>
            </div>
        <?php endif; ?>
    </div>
</div> <!-- .tasks-content -->
</div> <!-- .content-wrapper -->
</main>

</body>
</html>
