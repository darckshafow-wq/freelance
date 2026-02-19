<?php
require_once __DIR__ . '/../core/Database.php';

class SubTask {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function create($taskId, $title, $assignedTo = null, $dueDate = null) {
        $stmt = $this->pdo->prepare("INSERT INTO sub_tasks (task_id, title, assigned_to, due_date) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$taskId, $title, $assignedTo, $dueDate]);
    }

    public function getByTaskId($taskId) {
        $stmt = $this->pdo->prepare("SELECT st.*, u.name as assigned_name 
                                     FROM sub_tasks st 
                                     LEFT JOIN users u ON st.assigned_to = u.id 
                                     WHERE st.task_id = ? 
                                     ORDER BY st.created_at ASC");
        $stmt->execute([$taskId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateStatus($subTaskId, $status) {
        $stmt = $this->pdo->prepare("UPDATE sub_tasks SET status = ? WHERE id = ?");
        return $stmt->execute([$status, $subTaskId]);
    }

    public function getProgress($taskId) {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) as total, SUM(CASE WHEN status = 'completed' THEN 1 ELSE 0 END) as completed FROM sub_tasks WHERE task_id = ?");
        $stmt->execute([$taskId]);
        $res = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($res['total'] == 0) return 0;
        return round(($res['completed'] / $res['total']) * 100);
    }
}
