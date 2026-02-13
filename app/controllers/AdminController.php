<?php
require_once __DIR__ . '/../models/Tasks.php';
require_once __DIR__ . '/../models/UsersModel.php';

class AdminController {
    private $taskModel;
    private $userModel;

    public function __construct($pdo) {
        $this->taskModel = new Tasks($pdo);
        $this->userModel = new UsersModel($pdo);
    }

    /**
     * Tableau de bord admin avec stats, tâches en attente et derniers utilisateurs
     */
    public function dashboard() {
        $stats = [
            'users'     => $this->userModel->countUsers(),
            'tasks'     => $this->taskModel->countAllTasks(),
            'pending'   => $this->taskModel->countPendingTasks(),
            'published' => $this->taskModel->countPublishedTasks(),
            'validated' => $this->taskModel->countValidatedTasks()
        ];
        $tasks = $this->taskModel->getPendingTasks();
        $users = $this->userModel->getLatestUsers(5);

        include __DIR__ . '/../../public/dashboard_page/admin/admin.php';
    }

    /**
     * Page utilisateurs admin
     */
    public function ad_user() {
        $stats = [
            'users' => $this->userModel->countUsers()
        ];
        $users = $this->userModel->getAllUsers();
        include __DIR__ . '/../../public/dashboard_page/admin/ad_user.php';
    }

    /**
     * Page d'approbation des tâches
     */
    public function ad_aprobation() {
        $stats = [
            'tasks'   => $this->taskModel->countAllTasks(),
            'pending' => $this->taskModel->countPendingTasks(),
            'active'  => $this->taskModel->countPublishedTasks(),
            'revenue' => 1250 // Placeholder
        ];
        $tasks = $this->taskModel->getPendingTasks();
        include __DIR__ . '/../../public/dashboard_page/admin/ad_aprobation.php';
    }

    /**
     * Page de gestion des tâches
     */
    public function ad_tasks() {
        $stats = [
            'total' => $this->taskModel->countAllTasks(),
            'published' => $this->taskModel->countPublishedTasks()
        ];
        $tasks = $this->taskModel->getPublishedTasks();
        include __DIR__ . '/../../public/dashboard_page/admin/ad_tasks.php';
    }

    // --- Méthodes d'accès aux utilisateurs ---
    public function getUsers() {
        return $this->userModel->getAllUsers();
    }

    // --- Méthodes d'accès aux tâches ---
    public function getPendingTasks() {
        return $this->taskModel->getPendingTasks();
    }

    public function getPublishedTasks() {
        return $this->taskModel->getPublishedTasks();
    }

    // --- Méthodes de stats ---
    public function countTasks() {
        return $this->taskModel->countAllTasks();
    }

    public function countPendingTasks() {
        return $this->taskModel->countPendingTasks();
    }

    public function countPublishedTasks() {
        return $this->taskModel->countPublishedTasks();
    }

    public function countValidatedTasks() {
        return $this->taskModel->countValidatedTasks();
    }

    // --- Actions sur les tâches ---
    public function validateTask($id) {
        $id = intval($id);
        if ($id > 0) {
            $this->taskModel->validate($id);
        }
        // ✅ retour vers la modération
        header("Location: /free_lance_p/public/index.php?page=ad_aprobation");
        exit;
    }

    public function publishTask($id) {
        $id = intval($id);
        if ($id > 0) {
            $this->taskModel->publish($id);
        }
        // ✅ retour vers le listing global
        header("Location: /free_lance_p/public/index.php?page=ad_tasks");
        exit;
    }

    public function deleteTask($id) {
        $id = intval($id);
        if ($id > 0) {
            $this->taskModel->delete($id);
        }
        // ✅ retour vers le listing global
        header("Location: /free_lance_p/public/index.php?page=ad_tasks");
        exit;
    }
}