<?php
require_once __DIR__ . '/../models/notifications.php';

class NotificationController {
    private $notificationModel;

    public function __construct($pdo) {
        $this->notificationModel = new Notifications($pdo);
    }

    /**
     * Afficher les notifications de l'utilisateur
     */
    public function index() {
        $userId = $_SESSION['user_id'];
        return $this->notificationModel->getByUserId($userId);
    }

    /**
     * Marquer une notification comme lue
     */
    public function markRead($id) {
        $this->notificationModel->markAsRead($id);
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit();
    }
}
