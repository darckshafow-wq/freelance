<?php
require_once __DIR__ . '/../core/Database.php';

class Applications {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Récupérer les candidatures pour les tâches d'un client
    public function getByClientId($clientId) {
        $stmt = $this->pdo->prepare("
            SELECT a.*, t.title as task_title, u.name as freelance_name, u.email as freelance_email 
            FROM applications a 
            JOIN tasks t ON a.task_id = t.id 
            JOIN users u ON a.freelance_id = u.id 
            WHERE t.user_id = ? 
            ORDER BY a.created_at DESC
        ");
        $stmt->execute([$clientId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Mettre à jour le statut d'une candidature
    public function updateStatus($id, $status) {
        $stmt = $this->pdo->prepare("UPDATE applications SET status = ? WHERE id = ?");
        return $stmt->execute([$status, $id]);
    }

    // Créer une nouvelle candidature
    public function create($data) {
        $stmt = $this->pdo->prepare("INSERT INTO applications (task_id, freelance_id, message, bid_price, status, created_at) VALUES (:task_id, :freelance_id, :message, :bid_price, 'pending', NOW())");
        return $stmt->execute([
            ':task_id' => $data['task_id'],
            ':freelance_id' => $data['freelance_id'],
            ':message' => $data['message'],
            ':bid_price' => $data['bid_price']
        ]);
    }

    // Récupérer les candidatures d'un freelance
    public function getByFreelanceId($freelanceId) {
        $stmt = $this->pdo->prepare("
            SELECT a.*, t.title as task_title, t.status as task_status, u.name as client_name 
            FROM applications a 
            JOIN tasks t ON a.task_id = t.id 
            JOIN users u ON t.user_id = u.id 
            WHERE a.freelance_id = ? 
            ORDER BY a.created_at DESC
        ");
        $stmt->execute([$freelanceId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Vérifier si un freelance a déjà postulé à une tâche
    public function hasApplied($taskId, $freelanceId) {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM applications WHERE task_id = ? AND freelance_id = ?");
        $stmt->execute([$taskId, $freelanceId]);
        return $stmt->fetchColumn() > 0;
    }
}
