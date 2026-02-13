<?php
require_once __DIR__ . '/../models/Tasks.php';

class WelcomeController {
    private $taskModel;

    public function __construct($pdo) {
        $this->taskModel = new Tasks($pdo);
    }

    public function welcome() {
        if (isset($_SESSION['user'])) {
            $role = $_SESSION['user']['role'];
            if ($role === 'admin') header('Location: index.php?page=admin');
            elseif ($role === 'client') header('Location: index.php?page=client_dashboard');
            else header('Location: index.php?page=freelance_dashboard');
            exit;
        }
        
        // Récupérer les tâches pour la landing page (ex: 3 dernières)
        $tasks = $this->taskModel->getPublishedTasks();
        
        // Inclure la vue Welcome (Splash Screen) pour les visiteurs
        include __DIR__ . '/../../public/globale_page/Welcome.php';
    }
}