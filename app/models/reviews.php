<?php
require_once __DIR__ . '/../core/Database.php';

class Reviews {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    /**
     * Ajouter un avis
     */
    public function create($data) {
        $stmt = $this->pdo->prepare("INSERT INTO reviews (task_id, reviewer_id, reviewed_id, rating, comment, created_at) VALUES (:task_id, :reviewer_id, :reviewed_id, :rating, :comment, NOW())");
        return $stmt->execute([
            ':task_id' => $data['task_id'],
            ':reviewer_id' => $data['reviewer_id'],
            ':reviewed_id' => $data['reviewed_id'],
            ':rating' => $data['rating'],
            ':comment' => $data['comment']
        ]);
    }

    /**
     * Récupérer les avis d'un utilisateur
     */
    public function getByUserId($userId) {
        $stmt = $this->pdo->prepare("
            SELECT r.*, u.name as reviewer_name, t.title as task_title 
            FROM reviews r 
            JOIN users u ON r.reviewer_id = u.id 
            JOIN tasks t ON r.task_id = t.id 
            WHERE r.reviewed_id = ? 
            ORDER BY r.created_at DESC
        ");
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
