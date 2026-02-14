<?php
require_once __DIR__ . '/../models/messages.php';

class MessageController {
    private $messageModel;

    public function __construct($pdo) {
        $this->messageModel = new Messages($pdo);
    }

    /**
     * Envoyer un message
     */
    public function send() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $receiverId = $_POST['receiver_id'];
            $content = $_POST['content'];
            $senderId = $_SESSION['user_id'];

            if ($this->messageModel->send($senderId, $receiverId, $content)) {
                // Succès
            } else {
                // Erreur
            }
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit();
        }
    }

    /**
     * Charger la conversation entre l'utilisateur connecté et un autre
     */
    public function chat($otherUserId) {
        $currentUserId = $_SESSION['user_id'];
        $messages = $this->messageModel->getConversation($currentUserId, $otherUserId);
        $this->messageModel->markAsRead($currentUserId, $otherUserId);
        
        // Return or include view
        return $messages;
    }
}
