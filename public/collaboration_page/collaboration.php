<?php
if (!isset($_SESSION['user'])) {
    header('Location: index.php?page=login');
    exit;
}

$currentUser = $_SESSION['user'];
$receiverId = ($currentUser['id'] == $task['user_id']) ? ($app['freelance_id'] ?? null) : $task['user_id'];

// Default team if empty (for demo/context)
if (empty($team)) {
    $team = [
        ['name' => $currentUser['name'], 'role' => 'Chef de projet', 'id' => $currentUser['id']],
        ['name' => 'Sophie Dupont', 'role' => 'Développeuse Fullstack', 'id' => 999],
        ['name' => 'Thomas Weber', 'role' => 'UI Designer', 'id' => 888]
    ];
}

// Default sub-tasks if empty
if (empty($subTasks)) {
    $subTasks = [
        ['title' => 'Architecture du Design System', 'status' => 'completed', 'assigned_name' => 'Marc Antoine'],
        ['title' => 'Intégration des API Stripe & PayPal', 'status' => 'in_progress', 'assigned_name' => 'Sophie Dupont'],
        ['title' => 'Application des retours client v2.4', 'status' => 'todo', 'assigned_name' => null],
        ['title' => 'Optimisation SEO des pages landing', 'status' => 'todo', 'assigned_name' => 'Thomas Weber']
    ];
}

$progress = $progress ?? 65;
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Workspace : <?php echo htmlspecialchars($task['title']); ?> - FreelanceFlow</title>
    <link rel="stylesheet" href="/free_lance_p/public/assets/css/global.css">
    <link rel="stylesheet" href="/free_lance_p/public/assets/css/dashboard.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #f4f7f6; }
        .workspace-layout {
            display: grid;
            grid-template-columns: 280px 1fr 350px;
            height: 100vh;
            background: #f4f7f6;
        }
        
        /* Left Sidebar: Team & Progress */
        .workspace-sidebar {
            background: white;
            border-right: 1px solid #e2e8f0;
            padding: 24px;
            display: flex;
            flex-direction: column;
            gap: 32px;
        }
        .section-title {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 16px;
        }
        .section-title h3 { font-size: 1rem; font-weight: 700; color: #1e293b; margin: 0; }
        .badge-count { background: #dcfce7; color: #16a34a; font-size: 0.75rem; padding: 2px 8px; border-radius: 12px; }
        
        .team-list { display: flex; flex-direction: column; gap: 16px; }
        .team-member { display: flex; align-items: center; gap: 12px; }
        .member-avatar { width: 40px; height: 40px; border-radius: 50%; object-fit: cover; }
        .member-info h4 { font-size: 0.9rem; font-weight: 600; margin: 0; color: #1e293b; }
        .member-info p { font-size: 0.75rem; color: #64748b; margin: 0; }
        
        .invite-btn {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            padding: 10px;
            border-radius: 8px;
            font-size: 0.85rem;
            font-weight: 600;
            color: #1e293b;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            margin-top: 12px;
        }

        .progress-box {
            background: #e9f9ef;
            border-radius: 16px;
            padding: 20px;
            margin-top: auto;
        }
        .progress-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px; }
        .progress-header span { font-weight: 700; color: #16a34a; }
        .progress-bar-bg { background: white; height: 8px; border-radius: 4px; overflow: hidden; }
        .progress-bar-fill { background: #00e054; height: 100%; border-radius: 4px; }
        
        /* Center: Main Workspace */
        .workspace-main {
            padding: 40px;
            overflow-y: auto;
            background: #f4f7f6;
        }
        .workspace-header { margin-bottom: 32px; }
        .workspace-header h1 { font-size: 2rem; font-weight: 700; color: #1e293b; margin: 0 0 8px 0; }
        .project-meta { font-size: 0.95rem; color: #64748b; display: flex; align-items: center; gap: 12px; }
        .tag-team { background: #dcfce7; color: #16a34a; font-size: 0.75rem; font-weight: 700; padding: 4px 10px; border-radius: 6px; }

        .btn-new-task {
            background: #00e054;
            color: white;
            padding: 12px 24px;
            border-radius: 12px;
            font-weight: 700;
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 32px;
            box-shadow: 0 4px 12px rgba(0, 224, 84, 0.2);
        }

        .task-list-section h3 { font-size: 1.1rem; font-weight: 700; margin-bottom: 24px; display: flex; align-items: center; gap: 12px; }
        
        .tasks-container { display: flex; flex-direction: column; gap: 16px; }
        .task-item {
            background: white;
            border-radius: 16px;
            padding: 20px 24px;
            display: flex;
            align-items: center;
            gap: 20px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.02);
            border: 1px solid transparent;
            transition: all 0.2s;
        }
        .task-item:hover { border-color: #00e054; box-shadow: 0 4px 15px rgba(0,0,0,0.05); }
        .task-check { width: 24px; height: 24px; border: 2px solid #e2e8f0; border-radius: 50%; cursor: pointer; display: flex; align-items: center; justify-content: center; }
        .task-check.completed { background: #00e054; border-color: #00e054; color: white; }
        
        .task-content { flex: 1; }
        .task-content h4 { margin: 0 0 4px 0; font-size: 1rem; font-weight: 600; color: #1e293b; }
        .task-content.completed h4 { text-decoration: line-through; color: #94a3b8; }
        .task-meta { display: flex; gap: 16px; font-size: 0.75rem; color: #94a3b8; }
        .status-tag { padding: 2px 8px; border-radius: 4px; font-weight: 700; text-transform: uppercase; }
        .status-tag.en-cours { background: #fff7ed; color: #c2410c; }
        
        .task-assignee { display: flex; align-items: center; gap: 8px; font-size: 0.8rem; color: #64748b; }
        .assign-avatar { width: 32px; height: 32px; border-radius: 50%; background: #f1f5f9; border: 2px solid white; }
        
        /* Right Side Tabs */
        .workspace-chat {
            background: white;
            border-left: 1px solid #e2e8f0;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }
        .chat-tabs-header {
            display: flex;
            border-bottom: 1px solid #e2e8f0;
            background: #f8fafc;
        }
        .tab-btn {
            flex: 1;
            padding: 16px;
            border: none;
            background: transparent;
            font-size: 0.85rem;
            font-weight: 600;
            color: #64748b;
            cursor: pointer;
            border-bottom: 2px solid transparent;
            transition: all 0.2s;
        }
        .tab-btn.active {
            color: #00e054;
            border-bottom-color: #00e054;
            background: white;
        }
        .tab-btn:hover:not(.active) {
            background: #f1f5f9;
        }

        .tab-content {
            display: none;
            flex: 1;
            flex-direction: column;
            overflow: hidden;
        }
        .tab-content.active {
            display: flex;
        }

        .chat-messages { flex: 1; padding: 24px; overflow-y: auto; display: flex; flex-direction: column; gap: 20px; }
        .message-group { display: flex; flex-direction: column; gap: 6px; }
        .message-info { font-size: 0.75rem; color: #64748b; display: flex; gap: 8px; }
        .bubble { padding: 12px 16px; border-radius: 12px; font-size: 0.9rem; line-height: 1.5; max-width: 90%; }
        .bubble.received { background: #f1f5f9; color: #1e293b; align-self: flex-start; border-bottom-left-radius: 2px; }
        .bubble.sent { background: #00e054; color: white; align-self: flex-end; border-bottom-right-radius: 2px; }
        
        .chat-input-container { padding: 20px; border-top: 1px solid #e2e8f0; background: white; }
        .chat-input-wrapper {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 10px 14px;
            display: flex;
            gap: 12px;
            align-items: center;
        }
        .chat-input-wrapper input { flex: 1; background: transparent; border: none; outline: none; font-size: 0.9rem; padding: 4px 0; }
        .send-btn { 
            background: #00e054; 
            color: white; 
            border: none; 
            width: 32px; 
            height: 32px; 
            border-radius: 8px; 
            cursor: pointer; 
            display: flex; 
            align-items: center; 
            justify-content: center;
            transition: transform 0.2s;
        }
        .send-btn:hover { transform: scale(1.05); }

        /* Highlighted Hub Button */
        .btn-hub-highlight {
            background: linear-gradient(135deg, #00e054 0%, #00bc46 100%);
            color: white !important;
            padding: 8px 20px !important;
            border-radius: 12px !important;
            font-weight: 700 !important;
            box-shadow: 0 4px 12px rgba(0, 224, 84, 0.3);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }
        .btn-hub-highlight:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(0, 224, 84, 0.4);
        }

        /* --- Responsiveness Media Queries --- */

        /* Tablets & Small Desktops */
        @media (max-width: 1024px) {
            .workspace-layout {
                grid-template-columns: 250px 1fr;
                height: auto;
                min-height: 100vh;
            }
            .workspace-chat {
                grid-column: span 2;
                border-left: none;
                border-top: 1px solid #e2e8f0;
                height: 600px;
            }
        }

        /* Mobile Devices */
        @media (max-width: 768px) {
            .workspace-layout {
                grid-template-columns: 1fr;
            }
            .workspace-sidebar {
                grid-column: span 1;
                border-right: none;
                border-bottom: 1px solid #e2e8f0;
            }
            .workspace-main {
                padding: 24px 16px;
            }
            .workspace-chat {
                grid-column: span 1;
                height: 500px;
            }
            .workspace-header h1 {
                font-size: 1.5rem;
            }
            .task-item {
                padding: 16px;
                gap: 12px;
                flex-wrap: wrap;
            }
            .task-assignee {
                width: 100%;
                justify-content: flex-end;
                margin-top: 8px;
            }
            .project-meta {
                flex-wrap: wrap;
            }
        }

        /* Adjustments for the global sidebar if present */
        @media (max-width: 768px) {
            body {
                padding-left: 0; /* Assuming global sidebar might have padding */
            }
        }
    </style>
</head>
<body>
    <div class="workspace-layout">
        <!-- Sidebar -->
        <aside class="workspace-sidebar">
            <div class="team-section">
                <div class="section-title">
                    <h3>L'Équipe</h3>
                    <span class="badge-count">4 Actifs</span>
                </div>
                <div class="team-list">
                    <?php foreach ($team as $member): ?>
                    <div class="team-member">
                        <img src="https://ui-avatars.com/api/?name=<?php echo urlencode($member['name']); ?>&background=random" class="member-avatar">
                        <div class="member-info">
                            <h4><?php echo htmlspecialchars($member['name']); ?></h4>
                            <p><?php echo htmlspecialchars($member['role']); ?></p>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <button class="invite-btn"><span>👤+</span> Inviter un membre</button>
            </div>

            <div class="progress-box">
                <div class="progress-header">
                    <p style="font-size: 0.85rem; color: #16a34a; font-weight: 600; margin:0;">Avancement Total</p>
                    <span><?php echo $progress; ?>%</span>
                </div>
                <div class="progress-bar-bg">
                    <div class="progress-bar-fill" style="width: <?php echo $progress; ?>%;"></div>
                </div>
                <p style="font-size: 0.72rem; color: #16a34a; margin: 12px 0 0 0; line-height: 1.4;">Il reste 8 tâches avant d'atteindre le prochain jalon (Phase de Test).</p>
            </div>
        </aside>

        <!-- Main Workspace -->
        <main class="workspace-main">
            <div class="workspace-header">
                <h1>Team Collaboration Workspace</h1>
                <div class="project-meta">
                    <span>📄 Project ID: #7721 — Client: EcoDesign Group</span>
                    <span class="tag-team">ÉQUIPE 👥</span>
                </div>
            </div>

            <button class="btn-new-task"><span>+</span> Nouvelle Tâche</button>

            <section class="task-list-section">
                <h3><span>✔️</span> Liste des tâches actives</h3>
                <div class="tasks-container">
                    <?php foreach ($subTasks as $st): ?>
                    <div class="task-item">
                        <div class="task-check <?php echo $st['status'] === 'completed' ? 'completed' : ''; ?>">
                            <?php if ($st['status'] === 'completed'): ?>L<?php endif; ?>
                        </div>
                        <div class="task-content <?php echo $st['status'] === 'completed' ? 'completed' : ''; ?>">
                            <h4><?php echo htmlspecialchars($st['title']); ?></h4>
                            <div class="task-meta">
                                <?php if ($st['status'] === 'completed'): ?>
                                    <span style="color:#94a3b8;">TERMINÉ HIER</span>
                                <?php elseif ($st['status'] === 'in_progress'): ?>
                                    <span class="status-tag en-cours">EN COURS</span>
                                    <span>📅 14 Oct</span>
                                <?php else: ?>
                                    <span style="color:#94a3b8;">À venir</span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="task-assignee">
                            <?php if ($st['assigned_name']): ?>
                                <span>ASSIGNÉ À</span>
                                <strong><?php echo htmlspecialchars($st['assigned_name']); ?></strong>
                                <img src="https://ui-avatars.com/api/?name=<?php echo urlencode($st['assigned_name']); ?>&background=random" class="assign-avatar">
                            <?php else: ?>
                                <span class="assign-avatar" style="display:flex; align-items:center; justify-content:center; color:#94a3b8; font-size:1.2rem;">+</span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </section>
        </main>

        <!-- Right Side: Interaction Hub (Tabs) -->
        <aside class="workspace-chat">
            <div class="chat-tabs-header">
                <button class="tab-btn active" onclick="switchTab(event, 'chat')">Discussion</button>
                <button class="tab-btn" onclick="switchTab(event, 'files')">Partage</button>
                <button class="tab-btn" onclick="switchTab(event, 'info')">Infos</button>
            </div>
            
            <!-- Tab: Chat -->
            <div id="tab-chat" class="tab-content active">
                <div class="chat-messages" id="chatMessages">
                    <?php 
                    $stmt = $this->taskModel->getPdo()->prepare("SELECT * FROM messages WHERE task_id = ? ORDER BY created_at ASC");
                    $stmt->execute([$task['id']]);
                    $realMessages = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    
                    foreach ($realMessages as $msg): 
                        $isSent = $msg['sender_id'] == $currentUser['id'];
                    ?>
                    <div class="message-group" style="<?php echo $isSent ? 'align-items: flex-end;' : ''; ?>">
                        <div class="message-info" style="<?php echo $isSent ? 'justify-content: flex-end;' : ''; ?>">
                            <span><?php echo $isSent ? 'Moi' : 'Partenaire'; ?></span> • <span><?php echo date('H:i', strtotime($msg['created_at'])); ?></span>
                        </div>
                        <div class="bubble <?php echo $isSent ? 'sent' : 'received'; ?>">
                            <?php echo htmlspecialchars($msg['content']); ?>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>

                <form class="chat-input-container" id="messageForm">
                    <input type="hidden" id="taskId" value="<?php echo $task['id']; ?>">
                    <input type="hidden" id="receiverId" value="<?php echo $receiverId; ?>">
                    <input type="hidden" id="currentUserId" value="<?php echo $currentUser['id']; ?>">
                    
                    <div class="chat-input-wrapper">
                        <input type="text" id="messageContent" placeholder="Votre message..." required autocomplete="off">
                        <button type="submit" class="send-btn">➔</button>
                    </div>
                </form>
            </div>

            <!-- Tab: Files -->
            <div id="tab-files" class="tab-content">
                <div style="padding:40px; text-align:center; color:#64748b;">
                    <div style="font-size:3rem; margin-bottom:20px;">📂</div>
                    <h3>Espace de Partage</h3>
                    <p>Déposez vos documents, wireframes ou livrables ici pour les partager avec l'équipe.</p>
                    <button class="btn-new-task" style="margin:20px auto; background:#3b82f6;">Téléverser un fichier</button>
                </div>
            </div>

            <!-- Tab: Info -->
            <div id="tab-info" class="tab-content">
                <div style="padding:24px;">
                    <h3 style="font-size:1.1rem; margin-bottom:16px;">Détails de la mission</h3>
                    <div style="background:#f8fafc; padding:16px; border-radius:12px; border:1px solid #e2e8f0;">
                        <p style="font-size:0.9rem; margin-bottom:8px;"><strong>Budget :</strong> <?= number_format($task['price'], 0, ',', ' ') ?> €</p>
                        <p style="font-size:0.9rem; margin-bottom:8px;"><strong>Status :</strong> En cours 🔥</p>
                        <p style="font-size:0.9rem; margin-bottom:8px;"><strong>Deadline :</strong> <?= $task['deadline'] ?? 'Non définie' ?></p>
                        <hr style="border:0; border-top:1px solid #e2e8f0; margin:16px 0;">
                        <p style="font-size:0.85rem; color:#64748b; line-height:1.5;"><?= htmlspecialchars($task['description']) ?></p>
                    </div>
                </div>
            </div>
        </aside>
    </div>

    <!-- Modal Invitation -->
    <div id="inviteModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:1000; align-items:center; justify-content:center;">
        <div style="background:white; padding:24px; border-radius:16px; width:90%; max-width:400px; box-shadow:0 10px 25px rgba(0,0,0,0.1);">
            <h3 style="margin-top:0;">Inviter un collaborateur</h3>
            <p style="color:#64748b; font-size:0.9rem; margin-bottom:20px;">Saisissez l'email de la personne à ajouter à l'équipe.</p>
            <form id="inviteForm">
                <input type="hidden" name="task_id" value="<?php echo $task['id']; ?>">
                <div style="margin-bottom:16px;">
                    <label style="display:block; font-size:0.85rem; font-weight:600; margin-bottom:8px;">Email</label>
                    <input type="email" name="email" required placeholder="exemple@gmail.com" style="width:100%; padding:10px; border:1px solid #e2e8f0; border-radius:8px; outline:none;">
                </div>
                <div style="margin-bottom:20px;">
                    <label style="display:block; font-size:0.85rem; font-weight:600; margin-bottom:8px;">Rôle</label>
                    <select name="role" style="width:100%; padding:10px; border:1px solid #e2e8f0; border-radius:8px; outline:none;">
                        <option value="Membre">Membre</option>
                        <option value="Expert">Expert</option>
                        <option value="Développeur">Développeur</option>
                        <option value="Designer">Designer</option>
                    </select>
                </div>
                <div style="display:flex; gap:12px;">
                    <button type="button" onclick="closeInviteModal()" style="flex:1; padding:12px; border:1px solid #e2e8f0; border-radius:8px; background:white; cursor:pointer;">Annuler</button>
                    <button type="submit" style="flex:1; padding:12px; border:none; border-radius:8px; background:#00e054; color:white; font-weight:600; cursor:pointer;">Envoyer</button>
                </div>
            </form>
        </div>
    </div>

    <script src="/free_lance_p/public/assets/js/conversation.js"></script>
    <script>
        function switchTab(event, tabId) {
            // Hide all tab contents
            document.querySelectorAll('.tab-content').forEach(content => {
                content.classList.remove('active');
            });

            // Deactivate all tab buttons
            document.querySelectorAll('.tab-btn').forEach(button => {
                button.classList.remove('active');
            });

            // Show the selected tab content
            document.getElementById('tab-' + tabId).classList.add('active');

            // Activate the clicked tab button
            event.currentTarget.classList.add('active');
        }

        function openInviteModal() {
            document.getElementById('inviteModal').style.display = 'flex';
        }
        function closeInviteModal() {
            document.getElementById('inviteModal').style.display = 'none';
        }

        document.getElementById('inviteForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            
            fetch('index.php?page=invite_member', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    alert('Utilisateur invité avec succès !');
                    location.reload(); // Recharger pour voir le nouveau membre
                } else {
                    alert('Erreur : ' + data.message);
                }
            })
            .catch(error => console.error('Error:', error));
        });

        // Toggle task status
        document.querySelectorAll('.task-check').forEach(check => {
            check.addEventListener('click', function() {
                this.classList.toggle('completed');
                this.closest('.task-item').querySelector('.task-content').classList.toggle('completed');
            });
        });

        // Trigger invitation modal
        document.querySelector('.invite-btn').addEventListener('click', openInviteModal);
    </script>
</body>
</html>
