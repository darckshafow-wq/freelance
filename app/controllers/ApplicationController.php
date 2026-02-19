<?php
require_once __DIR__ . '/../models/Applications.php';

class ApplicationController {
    private $applicationModel;

    public function __construct($pdo) {
        $this->applicationModel = new Applications($pdo);
    }

    public function apply() {
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'freelance') {
            $_SESSION['error'] = "Vous devez être connecté en tant que freelance pour postuler.";
            header('Location: index.php?page=login');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $taskId = $_GET['id'] ?? null;
            $freelanceId = $_SESSION['user']['id'];
            $bidPrice = $_POST['bid_price'] ?? 0; // Prix proposé (optionnel, peut être le prix de la mission)
            $message = $_POST['message'] ?? '';

            if (!$taskId) {
                $_SESSION['error'] = "Mission invalide.";
                header('Location: index.php?page=tasks_list');
                exit;
            }

            // Vérifier si déjà postulé
            if ($this->applicationModel->hasApplied($taskId, $freelanceId)) {
                $_SESSION['error'] = "Vous avez déjà postulé à cette mission.";
                header("Location: index.php?page=task_detail&id=$taskId");
                exit;
            }

            $data = [
                'task_id' => $taskId,
                'freelance_id' => $freelanceId,
                'message' => $message,
                'bid_price' => $bidPrice
            ];

            if ($this->applicationModel->create($data)) {
                $_SESSION['success'] = "Candidature envoyée avec succès !";
            } else {
                $_SESSION['error'] = "Erreur lors de l'envoi de la candidature.";
            }

            header("Location: index.php?page=task_detail&id=$taskId");
            exit;
        }
    }

    public function myApplications() {
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'freelance') {
            header('Location: index.php?page=login');
            exit;
        }

        $freelanceId = $_SESSION['user']['id'];
        $applications = $this->applicationModel->getByFreelanceId($freelanceId);
        
        include __DIR__ . '/../../public/dashboard_page/freelance/my_applications.php';
    }

    public function clientApplications() {
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'client') {
            header('Location: index.php?page=login');
            exit;
        }

        $clientId = $_SESSION['user']['id'];
        $applications = $this->applicationModel->getByClientId($clientId);
        
        include __DIR__ . '/../../public/dashboard_page/client/client_applications.php';
    }

    public function updateApplicationStatus() {
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'client') {
            header('Location: index.php?page=login');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $applicationId = $_POST['application_id'] ?? null;
            $status = $_POST['status'] ?? null;

            if ($applicationId && in_array($status, ['accepted', 'rejected'])) {
                if ($this->applicationModel->updateStatus($applicationId, $status)) {
                    if ($status === 'accepted') {
                        // Recruitment logic
                        $app = $this->applicationModel->getApplicationById($applicationId);
                        if ($app) {
                            // Update task status to in_progress
                            require_once __DIR__ . '/../models/tasks.php';
                            $taskModel = new Tasks($this->applicationModel->getPdo());
                            $taskModel->setStatus($app['task_id'], 'in_progress');
                            
                            // Reject others
                            $this->applicationModel->rejectOthers($app['task_id'], $applicationId);
                            
                            $_SESSION['success'] = "Freelance recruté ! La mission est maintenant en cours.";
                        }
                    } else {
                        $_SESSION['success'] = "Candidature refusée.";
                    }
                } else {
                    $_SESSION['error'] = "Erreur lors de la mise à jour.";
                }
            }
        }
        
        header('Location: index.php?page=client_applications');
        exit;
    }
}
