<?php
require_once __DIR__ . '/../core/Database.php';

class Messages {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    /**
     * Envoyer un message
     */
    public function send($senderId, $receiverId, $content) {
        $stmt = $this->pdo->prepare("INSERT INTO messages (sender_id, receiver_id, content, created_at) VALUES (?, ?, ?, NOW())");
        return $stmt->execute([$senderId, $receiverId, $content]);
    }

    /**
     * Récupérer la conversation entre deux utilisateurs
     */
    public function getConversation($user1, $user2) {
        $stmt = $this->pdo->prepare("
            SELECT m.*, u.name as sender_name 
            FROM messages m 
            JOIN users u ON m.sender_id = u.id 
            WHERE (sender_id = :u1 AND receiver_id = :u2) 
               OR (sender_id = :u2 AND receiver_id = :u1) 
            ORDER BY created_at ASC
        ");
        $stmt->execute([':u1' => $user1, ':u2' => $user2]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Marquer les messages comme lus
     */
    public function markAsRead($receiverId, $senderId) {
        $stmt = $this->pdo->prepare("UPDATE messages SET is_read = 1 WHERE receiver_id = ? AND sender_id = ?");
        return $stmt->execute([$receiverId, $senderId]);
    }
}
