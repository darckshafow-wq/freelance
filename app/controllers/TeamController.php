<?php
require_once __DIR__ . '/../models/Team.php';
require_once __DIR__ . '/../models/User.php';

class TeamController {
    private $teamModel;
    private $userModel;

    public function __construct($pdo) {
        $this->teamModel = new Team($pdo);
        $this->userModel = new User($pdo);
    }

    /**
     * Inviter un membre à rejoindre l'équipe d'une tâche
     */
    public function addMember() {
        if (!isset($_SESSION['user'])) {
            header('Content-Type: application/json');
            echo json_encode(['status' => 'error', 'message' => 'Non authentifié']);
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $taskId = $_POST['task_id'] ?? null;
            $userEmail = $_POST['email'] ?? null;
            $role = $_POST['role'] ?? 'Member';

            if (!$taskId || !$userEmail) {
                header('Content-Type: application/json');
                echo json_encode(['status' => 'error', 'message' => 'Données manquantes']);
                exit;
            }

            // --- Access Control ---
            require_once __DIR__ . '/../models/Tasks.php';
            require_once __DIR__ . '/../models/Applications.php';
            $taskModel = new Tasks($this->teamModel->getPdo());
            $appModel = new Applications($this->teamModel->getPdo());

            $task = $taskModel->getTaskById($taskId);
            if (!$task) {
                header('Content-Type: application/json');
                echo json_encode(['status' => 'error', 'message' => 'Mission non trouvée']);
                exit;
            }

            // Find accepted freelance
            $stmt = $this->teamModel->getPdo()->prepare("SELECT * FROM application WHERE task_id = ? AND status = 'accepted' LIMIT 1");
            $stmt->execute([$taskId]);
            $app = $stmt->fetch(PDO::FETCH_ASSOC);

            $isOwner = ($_SESSION['user']['id'] == $task['user_id']);
            $isFreelancer = ($app && $_SESSION['user']['id'] == $app['freelance_id']);

            if (!$isOwner && !$isFreelancer) {
                header('Content-Type: application/json');
                echo json_encode(['status' => 'error', 'message' => 'Accès refusé : vous ne pouvez pas inviter de membres pour cette mission.']);
                exit;
            }
            // --- End Access Control ---

            // Trouver l'utilisateur par son email
            $user = $this->userModel->getUserByEmail($userEmail);
            if (!$user) {
                header('Content-Type: application/json');
                echo json_encode(['status' => 'error', 'message' => 'Utilisateur non trouvé']);
                exit;
            }

            try {
                $this->teamModel->addMember($taskId, $user['id'], $role);
                header('Content-Type: application/json');
                echo json_encode(['status' => 'success', 'user' => [
                    'name' => $user['name'],
                    'role' => $role
                ]]);
            } catch (Exception $e) {
                header('Content-Type: application/json');
                echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
            }
            exit;
        }
    }
}
