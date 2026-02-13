<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Publier une mission - FreelanceFlow</title>
    <link rel="stylesheet" href="/free_lance_p/public/assets/css/global.css">
    <link rel="stylesheet" href="/free_lance_p/public/assets/css/dashboard.css">
</head>
<body>

<?php include __DIR__ . '/../../includes/sidebar_client.php'; ?>

<main class="main-content">
    <?php include __DIR__ . '/../../includes/header_client.php'; ?>

    <div class="content-wrapper">
        <h1 class="page-title">Publier une nouvelle mission</h1>

        <div class="card" style="max-width: 800px; margin: 0 auto;">
            
            <?php
            // Messages flash
            if (isset($_SESSION['error'])): ?>
                <div style="background:#fee2e2; color:#b91c1c; padding:1rem; border-radius:8px; margin-bottom:1.5rem;">
                    <?= htmlspecialchars($_SESSION['error']) ?>
                    <?php unset($_SESSION['error']); ?>
                </div>
            <?php endif; ?>
            
            <?php if (isset($_SESSION['success'])): ?>
                <div style="background:#dcfce7; color:#15803d; padding:1rem; border-radius:8px; margin-bottom:1.5rem;">
                    <?= htmlspecialchars($_SESSION['success']) ?>
                    <?php unset($_SESSION['success']); ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="index.php?page=create_task">
                <div style="margin-bottom: 1.5rem;">
                    <label for="title" style="display:block; margin-bottom:0.5rem; font-weight:600; color:var(--text-dark);">Titre de la mission *</label>
                    <input type="text" id="title" name="title" required class="search-input" style="width:100%; background:#fff; border-radius:8px; padding:0.8rem;" placeholder="Ex: Développement site E-commerce">
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
                    <div>
                        <label for="price" style="display:block; margin-bottom:0.5rem; font-weight:600; color:var(--text-dark);">Budget (EUR) *</label>
                        <input type="number" id="price" name="price" required min="0" step="0.01" class="search-input" style="width:100%; background:#fff; border-radius:8px; padding:0.8rem;" placeholder="0.00">
                    </div>
                    <div>
                        <label for="deadline" style="display:block; margin-bottom:0.5rem; font-weight:600; color:var(--text-dark);">Date limite</label>
                        <input type="date" id="deadline" name="deadline" class="search-input" style="width:100%; background:#fff; border-radius:8px; padding:0.8rem;">
                    </div>
                </div>

                <div style="margin-bottom: 1.5rem;">
                    <label for="localisation" style="display:block; margin-bottom:0.5rem; font-weight:600; color:var(--text-dark);">Localisation *</label>
                    <input type="text" id="localisation" name="localisation" required class="search-input" style="width:100%; background:#fff; border-radius:8px; padding:0.8rem;" placeholder="Ex: Paris (ou Télétravail)">
                </div>

                <div style="margin-bottom: 1.5rem;">
                    <label for="description" style="display:block; margin-bottom:0.5rem; font-weight:600; color:var(--text-dark);">Description détaillée *</label>
                    <textarea id="description" name="description" required minlength="50" class="search-input" style="width:100%; background:#fff; border-radius:8px; padding:0.8rem; min-height:150px; resize:vertical;" placeholder="Décrivez votre besoin avec précision..."></textarea>
                </div>

                <div style="margin-bottom: 2rem;">
                    <label style="display:flex; align-items:center; cursor:pointer;">
                        <input type="checkbox" name="is_permanent" value="1" style="width:18px; height:18px; margin-right:0.8rem;">
                        <span style="color:var(--text-dark);">Ceci est une mission permanente / récurrente</span>
                    </label>
                </div>

                <div style="display:flex; gap:1rem;">
                    <button type="submit" name="publish" class="btn btn-primary" style="padding:0.8rem 1.5rem;">🚀 Publier la mission</button>
                    <button type="submit" name="draft" class="btn" style="background:#e5e7eb; color:#374151; padding:0.8rem 1.5rem;">💾 Enregistrer brouillon</button>
                </div>
            </form>
        </div>
    </div>
</main>

</body>
</html>