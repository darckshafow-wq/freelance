<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($task['title'] ?? 'Détail Mission') ?> - FreelanceFlow</title>
    <link rel="stylesheet" href="/free_lance_p/public/assets/css/global.css">
    <link rel="stylesheet" href="/free_lance_p/public/assets/css/dashboard.css">
    <script src="/free_lance_p/public/assets/js/script.js" defer></script>
</head>
<body>

<?php 
$role = $_SESSION['user']['role'] ?? 'guest';
$isLoggedIn = isset($_SESSION['user']);
?>

<?php if ($role === 'freelance'): ?>
    <?php include __DIR__ . '/../../includes/sidebar_freelance.php'; ?>
    <main class="main-content">
        <?php include __DIR__ . '/../../includes/header_freelance.php'; ?>
        <div class="content-wrapper">
<?php elseif ($role === 'client'): ?>
    <?php include __DIR__ . '/../../includes/sidebar_client.php'; ?>
    <main class="main-content">
        <?php include __DIR__ . '/../../includes/header_client.php'; ?>
        <div class="content-wrapper">
<?php elseif ($role === 'admin'): ?>
    <?php include __DIR__ . '/../../includes/sidebar_admin.php'; ?>
    <main class="main-content">
        <?php include __DIR__ . '/../../includes/header_admin.php'; ?>
        <div class="content-wrapper">
<?php else: ?>
    <?php include __DIR__ . '/../../includes/header_public.php'; ?>
    <main class="container" style="margin-top:100px; width:90%; max-width:1200px; margin-left:auto; margin-right:auto;">
<?php endif; ?>
    <div class="task-detail-container">
    <?php if ($task): ?>
        <div class="detail-header">
            <div class="breadcrumb-area">
                <a href="index.php?page=tasks_list" class="back-link">
                    <span class="icon">←</span> Retour aux missions
                </a>
            </div>
            <div class="header-main">
                <div class="title-meta">
                    <div class="badge-group">
                        <span class="status-badge category"><?= htmlspecialchars($task['category'] ?? 'Général') ?></span>
                        <?php if (!empty($task['urgent']) && $task['urgent']): ?>
                            <span class="status-badge urgent">URGENT</span>
                        <?php endif; ?>
                    </div>
                    <h1><?= htmlspecialchars($task['title']) ?></h1>
                    <p class="subtitle"><?= htmlspecialchars($task['domain'] ?? '') ?></p>
                </div>
                <div class="price-card">
                    <div class="price-value"><?= number_format($task['price'], 0, ',', ' ') ?> €</div>
                    <div class="price-label">Budget estimé</div>
                </div>
            </div>
        </div>

        <div class="detail-content-grid">
            <div class="main-info">
                <section class="info-section">
                    <h2>Description de la mission</h2>
                    <div class="description-text">
                        <?= nl2br(htmlspecialchars($task['description'])) ?>
                    </div>
                </section>

                <?php if (!empty($task['requirements'])): ?>
                    <section class="info-section">
                        <h2>Prérequis</h2>
                        <ul class="requirements-list">
                            <?php foreach (explode("\n", $task['requirements']) as $req): ?>
                                <li><?= htmlspecialchars($req) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </section>
                <?php endif; ?>

                <?php if (!empty($task['attachments'])): ?>
                    <section class="info-section">
                        <h2>Fichiers joints</h2>
                        <div class="attachments-grid">
                            <?php foreach ($task['attachments'] as $file): ?>
                                <a href="<?= htmlspecialchars($file['url']) ?>" class="attachment-item">
                                    <span class="icon">📎</span> <?= htmlspecialchars($file['name']) ?>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    </section>
                <?php endif; ?>
            </div>

            <aside class="sidebar-info">
                <div class="stats-card-premium">
                    <div class="stat-item">
                        <span class="icon">📍</span>
                        <div class="stat-detail">
                            <label>Localisation</label>
                            <p><?= htmlspecialchars($task['localisation'] ?? 'Non précisé') ?></p>
                        </div>
                    </div>
                    <div class="stat-item">
                        <span class="icon">⏱️</span>
                        <div class="stat-detail">
                            <label>Durée</label>
                            <p><?= htmlspecialchars($task['duration'] ?? 'Non précisé') ?></p>
                        </div>
                    </div>
                    <div class="stat-item">
                        <span class="icon">📅</span>
                        <div class="stat-detail">
                            <label>Date limite</label>
                            <p><?= htmlspecialchars($task['deadline'] ?? 'Aucune') ?></p>
                        </div>
                    </div>
                </div>

                <div class="application-card">
                    <h3>Postuler à cette mission</h3>
                    
                    <?php if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'freelance'): ?>
                        <form method="post" action="index.php?page=apply_task&id=<?= $task['id'] ?>" class="premium-form">
                            <div class="form-group">
                                <label for="message">Message de motivation</label>
                                <textarea name="message" id="message" rows="5" required placeholder="Expliquez pourquoi vous êtes le meilleur candidat..."></textarea>
                            </div>
                            
                            <div class="form-group">
                                <label for="bid_price">Votre tarif (€)</label>
                                <div class="input-with-icon">
                                    <input type="number" name="bid_price" id="bid_price" value="<?= htmlspecialchars($task['price']) ?>" required>
                                    <span class="input-icon">€</span>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary-premium full-width">Envoyer ma candidature</button>
                        </form>
                    <?php elseif (isset($_SESSION['user'])): ?>
                        <div class="status-msg warning">
                            Seuls les freelances peuvent postuler aux missions.
                        </div>
                    <?php else: ?>
                        <div class="auth-required">
                            <p>Vous devez être connecté pour postuler.</p>
                            <div class="auth-buttons">
                                <a href="index.php?page=login" class="btn btn-primary-premium">Se connecter</a>
                                <a href="index.php?page=register" class="btn btn-outline-premium">S'inscrire</a>
                            </div>
                        </div>
                    <?php endif; ?>
                    
                    <p class="terms-text">En postulant, vous acceptez les conditions de FreelanceFlow.</p>
                </div>
            </aside>
        </div>
    <?php else: ?>
        <div class="error-state">
            <span class="error-icon">❌</span>
            <p>Mission introuvable ou supprimée.</p>
            <a href="index.php?page=tasks_list" class="btn btn-primary-premium">Retour à la liste</a>
        </div>
    <?php endif; ?>
    </div> <!-- .content-wrapper (or closing card) -->
    <?php if ($isLoggedIn): ?>
        </div> <!-- .content-wrapper -->
    <?php endif; ?>
</main>
