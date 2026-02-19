<?php
require_once __DIR__ . '/../models/Freelance.php';

class FreelanceController {
    private Freelance $freelanceModel;

    public function __construct(PDO $pdo) {
        $this->freelanceModel = new Freelance($pdo);
    }

    /**
     * Tableau de bord freelance avec stats
     */
    public function dashboard(int $userId) {
    $stats = [
        'candidatures' => $this->freelanceModel->getCandidaturesCount($userId),
        'active_tasks' => $this->freelanceModel->getActiveTasksCount($userId),
        'monthly_earnings' => $this->freelanceModel->getMonthlyEarnings($userId),
        'recent_applications' => $this->freelanceModel->getRecentApplications($userId, 5),
    ];

    include __DIR__ . '/../../public/dashboard_page/freelance/dashboard_freelance.php';
}
}