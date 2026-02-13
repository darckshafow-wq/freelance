<?php
require_once __DIR__ . '/../models/Tasks.php';

class TaskController {
    private $taskModel;

    public function __construct($pdo) {
        $this->taskModel = new Tasks($pdo);
    }

    /**
     * Créer une nouvelle tâche
     */
    public function create() {
        if (!isset($_SESSION['user']) || !isset($_SESSION['user']['id'])) {
            $_SESSION['error'] = "Vous devez être connecté pour créer une tâche.";
            header("Location: index.php?page=login");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'user_id'     => intval($_SESSION['user']['id']),
                'title'       => $_POST['title'] ?? '',
                'description' => $_POST['description'] ?? '',
                'price'       => $_POST['price'] ?? 0,
                'localisation'=> $_POST['localisation'] ?? '',
                'deadline'    => $_POST['deadline'] ?? null,
                'is_permanent'=> isset($_POST['is_permanent']) ? 1 : 0
            ];

            if (empty($data['title']) || empty($data['description']) || empty($data['price'])) {
                $_SESSION['error'] = "Titre, description et prix sont obligatoires.";
                header("Location: index.php?page=tasks_fiche");
                exit;
            }

            try {
                $this->taskModel->create($data);
                $_SESSION['success'] = "Votre tâche a été créée avec succès.";
                header("Location: index.php?page=client_dashboard");
                exit;
            } catch (Exception $e) {
                $_SESSION['error'] = "Erreur lors de la création : " . $e->getMessage();
                header("Location: index.php?page=tasks_fiche");
                exit;
            }
        }
    }

    /**
     * Liste des tâches publiées
     */
    public function listPublished() {
        $tasks = $this->taskModel->getPublishedTasks();
        include __DIR__ . '/../../public/tasks_page/tasks_list.php'; // ✅ corrige vers une vue liste
    }

    /**
     * Détail d'une tâche par ID
     */
    public function getTaskById($id) {
        return $this->taskModel->getTaskById($id);
    }

    /**
     * Liste des tâches en attente (utile si tu veux une page publique ou admin)
     */
    public function listPending() {
        $tasks = $this->taskModel->getPendingTasks();
        include __DIR__ . '/../../public/tasks_page/tasks_pending.php';
    }
}