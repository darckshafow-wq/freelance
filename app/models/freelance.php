<?php
require_once __DIR__ . '/../core/database.php';

class Freelance {
    private PDO $pdo;

    public function __construct($pdo = null) {
        if ($pdo) {
            $this->pdo = $pdo;
        } else {
            $db = new Database();
            $this->pdo = $db->getConnection();
        }
    }

    /**
     * Compter le nombre total de candidatures d'un utilisateur
     * @param int $userId
     * @return int
     */
    public function getCandidaturesCount(int $userId): int {
        try {
            $stmt = $this->pdo->prepare("
                SELECT COUNT(*) 
                FROM application 
                WHERE freelance_id = :fid
            ");
            $stmt->execute([':fid' => $userId]);
            return (int) $stmt->fetchColumn();
        } catch (PDOException $e) {
            error_log("Erreur SQL getCandidaturesCount : " . $e->getMessage());
            return 0;
        }
    }

    /**
     * Nombre de missions en cours pour un freelance
     */
    public function getActiveTasksCount(int $freelanceId): int {
        try {
            $stmt = $this->pdo->prepare("
                SELECT COUNT(DISTINCT t.id) 
                FROM tasks t
                LEFT JOIN application a ON t.id = a.task_id AND a.freelance_id = :fid AND a.status = 'accepted'
                LEFT JOIN team_members tm ON t.id = tm.task_id AND tm.user_id = :fid
                WHERE (a.id IS NOT NULL OR tm.id IS NOT NULL) AND t.status != 'completed'
            ");
            $stmt->execute([':fid' => $freelanceId]);
            return (int) $stmt->fetchColumn();
        } catch (PDOException $e) {
            error_log("Erreur SQL getActiveTasksCount : " . $e->getMessage());
            return 0;
        }
    }

    /**
     * Gains du mois pour un freelance
     */
    public function getMonthlyEarnings(int $freelanceId): float {
        try {
            $stmt = $this->pdo->prepare("
                SELECT COALESCE(SUM(t.price),0) 
                FROM tasks t
                LEFT JOIN application a ON t.id = a.task_id AND a.freelance_id = :fid AND a.status = 'accepted'
                LEFT JOIN team_members tm ON t.id = tm.task_id AND tm.user_id = :fid
                WHERE t.status = 'completed' AND (a.id IS NOT NULL OR tm.id IS NOT NULL)
            ");
            $stmt->execute([':fid' => $freelanceId]);
            return (float) $stmt->fetchColumn();
        } catch (PDOException $e) {
            error_log("Erreur SQL getMonthlyEarnings : " . $e->getMessage());
            return 0.0;
        }
    }

    /**
     * Dernières candidatures envoyées par un freelance
     */
    public function getRecentApplications(int $freelanceId, int $limit = 5): array {
        try {
            // Include applications AND team invitations
            $stmt = $this->pdo->prepare("
                SELECT DISTINCT a.id, t.title, t.domain, t.price, 'accepted' as status, a.created_at
                FROM application a
                JOIN tasks t ON a.task_id = t.id
                WHERE a.freelance_id = :fid AND a.status = 'accepted'
                UNION
                SELECT DISTINCT tm.id, t.title, t.domain, t.price, 'team' as status, t.created_at
                FROM team_members tm
                JOIN tasks t ON tm.task_id = t.id
                WHERE tm.user_id = :fid
                ORDER BY created_at DESC
                LIMIT :limit
            ");
            $stmt->bindValue(':fid', $freelanceId, PDO::PARAM_INT);
            $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erreur SQL getRecentApplications : " . $e->getMessage());
            return [];
        }
    }
}