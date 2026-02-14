<?php
require_once __DIR__ . '/../core/Database.php';

class Payments {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    /**
     * Créer un nouveau paiement
     */
    public function create($data) {
        $stmt = $this->pdo->prepare("INSERT INTO payments (task_id, sender_id, receiver_id, amount, status, transaction_ref, created_at) VALUES (:task_id, :sender_id, :receiver_id, :amount, 'pending', :transaction_ref, NOW())");
        return $stmt->execute([
            ':task_id' => $data['task_id'],
            ':sender_id' => $data['sender_id'],
            ':receiver_id' => $data['receiver_id'],
            ':amount' => $data['amount'],
            ':transaction_ref' => $data['transaction_ref'] ?? null
        ]);
    }

    /**
     * Mettre à jour le statut du paiement
     */
    public function updateStatus($id, $status) {
        $stmt = $this->pdo->prepare("UPDATE payments SET status = ? WHERE id = ?");
        return $stmt->execute([$status, $id]);
    }

    /**
     * Récupérer les paiements d'un utilisateur (en tant qu'émetteur ou récepteur)
     */
    public function getByUserId($userId) {
        $stmt = $this->pdo->prepare("SELECT * FROM payments WHERE sender_id = ? OR receiver_id = ? ORDER BY created_at DESC");
        $stmt->execute([$userId, $userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
