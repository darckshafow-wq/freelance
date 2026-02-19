<?php
require_once __DIR__ . '/../core/Database.php';

class message {
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo=$pdo;
    }

    public function getPdo() {
        return $this->pdo;
    }

    public function send($task_id, $sender_id, $receiver_id, $content){
        $stmt = $this->pdo->prepare("INSERT INTO messages (task_id, sender_id, receiver_id, content) VALUES (:task_id, :sender_id, :receiver_id, :content)");
        $stmt->execute([
            'task_id'     => $task_id,
            'sender_id'   => $sender_id,
            'receiver_id' => $receiver_id,
            'content'     => $content
        ]);
    }
    public function getConversation($task_id,$user1,$user2){
        $stmt= $this->pdo->prepare("SELECT * FROM messages WHERE task_id=:task_id AND ((sender_id =:user1 AND receiver_id= :user2)OR(sender_id =:user2 AND receiver_id= :user1))ORDER BY created_at ASC");
        $stmt->execute([
            'task_id' => $task_id,
            'user1'   => $user1,
            'user2'   => $user2
        ]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getNewMessages($task_id, $user1, $user2, $last_id) {
        $stmt = $this->pdo->prepare("SELECT * FROM messages WHERE task_id = :task_id AND id > :last_id AND ((sender_id = :user1 AND receiver_id = :user2) OR (sender_id = :user2 AND receiver_id = :user1)) ORDER BY created_at ASC");
        $stmt->execute([
            'task_id' => $task_id,
            'last_id' => $last_id,
            'user1'   => $user1,
            'user2'   => $user2
        ]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getUserConversations($userId) {
        $stmt = $this->pdo->prepare("
            SELECT m.*, u.name as other_user_name, t.title as task_title
            FROM messages m
            INNER JOIN users u ON u.id = (CASE WHEN m.sender_id = :userId THEN m.receiver_id ELSE m.sender_id END)
            INNER JOIN tasks t ON t.id = m.task_id
            WHERE (m.sender_id = :userId OR m.receiver_id = :userId)
            AND m.id IN (
                SELECT MAX(id)
                FROM messages
                WHERE sender_id = :userId OR receiver_id = :userId
                GROUP BY task_id, (CASE WHEN sender_id = :userId THEN receiver_id ELSE sender_id END)
            )
            ORDER BY m.created_at DESC
        ");
        $stmt->execute(['userId' => $userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function countUnreadMessages($userId) {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM messages WHERE receiver_id = ? AND is_read = 0");
        $stmt->execute([$userId]);
        return $stmt->fetchColumn();
    }
}