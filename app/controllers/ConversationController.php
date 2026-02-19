<?php
require_once __DIR__ . '/../models/Tasks.php';
require_once __DIR__ . '/../models/message.php';

class ConversationController {
    private $messageModel;

    public function __construct($pdo)
    {
        $this->messageModel= new message($pdo);
    }

    public function index($userId) {
        $conversations = $this->messageModel->getUserConversations($userId);
        include __DIR__ . '/../../public/dashboard_page/shared/messages.php';
    }

    public function show($tasks_id, $user1, $user2){
        // Mark as read
        $stmt = $this->messageModel->getPdo()->prepare("UPDATE messages SET is_read = 1 WHERE task_id = ? AND sender_id = ? AND receiver_id = ?");
        $stmt->execute([$tasks_id, $user2, $user1]);

        $messages = $this->messageModel->getConversation($tasks_id, $user1, $user2);
        
        // Fetch receiver name
        require_once __DIR__ . '/../models/User.php';
        $userModel = new User();
        $receiver = $userModel->getUserById($user2);
        
        include __DIR__ . '/../../public/conversation_page/conversation_page.php';
    }

    public function getNewMessages($task_id, $user1, $user2, $last_id){
        $messages = $this->messageModel->getNewMessages($task_id, $user1, $user2, $last_id);
        header('Content-Type: application/json');
        echo json_encode($messages);
        exit;
    }

    public function sendMessage($task_id, $sender_id, $receiver_id, $content){
        try {
            $this->messageModel->send($task_id, $sender_id, $receiver_id, $content);
            header('Content-Type: application/json');
            echo json_encode(['status' => 'success']);
        } catch (Exception $e) {
            header('Content-Type: application/json');
            http_response_code(500);
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
        exit;
    }
}