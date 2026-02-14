<?php
require_once __DIR__ . '/../core/Database.php';

class Notifications {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    /**
     * Créer une notification
     */
    public function create($userId, $type, $message) {
        $stmt = $this->pdo->prepare("INSERT INTO notifications (user_id, type, message, created_at) VALUES (?, ?, ?, NOW())");
        return $stmt->execute([$userId, $type, $message]);
    }

    /**
     * Récupérer les notifications d'un utilisateur
     */
    public function getByUserId($userId, $unreadOnly = false) {
        $sql = "SELECT * FROM notifications WHERE user_id = ?";
        if ($unreadOnly) {
            $sql .= " AND is_read = 0";
        }
        $sql .= " ORDER BY created_at DESC";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Marquer comme lu
     */
    public function markAsRead($id) {
        $stmt = $this->pdo->prepare("UPDATE notifications SET is_read = 1 WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
