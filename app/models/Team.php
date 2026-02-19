<?php
require_once __DIR__ . '/../core/Database.php';

class Team {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getPdo() {
        return $this->pdo;
    }

    public function addMember($taskId, $userId, $role = 'Member') {
        $stmt = $this->pdo->prepare("INSERT INTO team_members (task_id, user_id, role) VALUES (?, ?, ?)");
        return $stmt->execute([$taskId, $userId, $role]);
    }

    public function getMembers($taskId) {
        $stmt = $this->pdo->prepare("SELECT tm.*, u.name, u.email 
                                     FROM team_members tm 
                                     JOIN users u ON tm.user_id = u.id 
                                     WHERE tm.task_id = ?");
        $stmt->execute([$taskId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function removeMember($taskId, $userId) {
        $stmt = $this->pdo->prepare("DELETE FROM team_members WHERE task_id = ? AND user_id = ?");
        return $stmt->execute([$taskId, $userId]);
    }
}
