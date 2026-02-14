<?php
require_once __DIR__ . '/../models/reviews.php';

class ReviewController {
    private $reviewModel;

    public function __construct($pdo) {
        $this->reviewModel = new Reviews($pdo);
    }

    /**
     * Ajouter un avis sur un utilisateur (Freelance ou Client)
     */
    public function add() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $data = [
                    'task_id'     => $_POST['task_id'],
                    'reviewer_id' => $_SESSION['user_id'],
                    'reviewed_id' => $_POST['reviewed_id'],
                    'rating'      => $_POST['rating'],
                    'comment'     => $_POST['comment']
                ];

                if ($this->reviewModel->create($data)) {
                    $_SESSION['success'] = "Votre avis a été enregistré avec succès.";
                } else {
                    $_SESSION['error'] = "Erreur lors de l'enregistrement de l'avis.";
                }
            } catch (Exception $e) {
                $_SESSION['error'] = "Erreur : " . $e->getMessage();
            }
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit();
        }
    }

    /**
     * Afficher les avis d'un utilisateur
     */
    public function list($userId) {
        return $this->reviewModel->getByUserId($userId);
    }
}
