<?php
if (!isset($_SESSION['user'])) {
    header('Location: /free_lance_p/public/index.php?page=login');
    exit;
}

$currentUser = $_SESSION['user'];
$receiverName = $receiver['name'] ?? 'Utilisateur';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Conversation avec <?php echo htmlspecialchars($receiverName); ?> - FreelanceFlow</title>
    <link rel="stylesheet" href="/free_lance_p/public/assets/css/global.css">
    <link rel="stylesheet" href="/free_lance_p/public/assets/css/dashboard.css">
    <style>
        .chat-container {
            display: flex;
            flex-direction: column;
            height: calc(100vh - 120px);
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.05);
            overflow: hidden;
            margin: 20px;
        }
        .chat-header {
            padding: 20px;
            background: var(--primary-color, #2563eb);
            color: white;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .chat-messages {
            flex: 1;
            padding: 20px;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            gap: 15px;
            background: #f8fafc;
        }
        .message {
            max-width: 70%;
            padding: 12px 16px;
            border-radius: 12px;
            font-size: 0.95rem;
            line-height: 1.4;
            position: relative;
        }
        .message.sent {
            align-self: flex-end;
            background: var(--primary-color, #2563eb);
            color: white;
            border-bottom-right-radius: 2px;
        }
        .message.received {
            align-self: flex-start;
            background: white;
            color: #1e293b;
            border-bottom-left-radius: 2px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        }
        .chat-input-area {
            padding: 20px;
            background: white;
            border-top: 1px solid #e2e8f0;
            display: flex;
            gap: 10px;
        }
        .chat-input {
            flex: 1;
            padding: 12px;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            outline: none;
            transition: border-color 0.2s;
        }
        .chat-input:focus {
            border-color: var(--primary-color, #2563eb);
        }
        .send-btn {
            background: var(--primary-color, #2563eb);
            color: white;
            border: none;
            padding: 0 24px;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 500;
            transition: opacity 0.2s;
        }
        .send-btn:hover {
            opacity: 0.9;
        }
        .message-time {
            font-size: 0.75rem;
            margin-top: 4px;
            opacity: 0.7;
            display: block;
        }
    </style>
</head>
<body>
    <?php 
    $role = $currentUser['role'];
    if ($role === 'admin') include __DIR__ . '/../../includes/sidebar_admin.php';
    elseif ($role === 'client') include __DIR__ . '/../../includes/sidebar_client.php';
    elseif ($role === 'freelance') include __DIR__ . '/../../includes/sidebar_freelance.php';
    ?>

    <main class="main-content">
        <div class="chat-container">
            <div class="chat-header">
                <div>
                    <h2 style="margin:0; font-size: 1.25rem;"><?php echo htmlspecialchars($receiverName); ?></h2>
                    <small style="opacity: 0.8;">En ligne</small>
                </div>
                <a href="index.php?page=messages" style="color: white; text-decoration: none;">Retour</a>
            </div>

            <div class="chat-messages" id="chatMessages">
                <?php foreach ($messages as $msg): ?>
                    <div class="message <?php echo ($msg['sender_id'] == $currentUser['id']) ? 'sent' : 'received'; ?>" data-id="<?php echo $msg['id']; ?>">
                        <?php echo htmlspecialchars($msg['content']); ?>
                        <span class="message-time"><?php echo date('H:i', strtotime($msg['created_at'])); ?></span>
                    </div>
                <?php endforeach; ?>
            </div>

            <form class="chat-input-area" id="messageForm">
                <input type="hidden" id="taskId" value="<?php echo $tasks_id; ?>">
                <input type="hidden" id="receiverId" value="<?php echo $user2; ?>">
                <input type="hidden" id="currentUserId" value="<?php echo $currentUser['id']; ?>">
                
                <input type="text" class="chat-input" id="messageContent" placeholder="Écrivez votre message..." required autocomplete="off">
                <button type="submit" class="send-btn">Envoyer</button>
            </form>
        </div>
    </main>

    <script src="/free_lance_p/public/assets/js/conversation.js"></script>
</body>
</html>
