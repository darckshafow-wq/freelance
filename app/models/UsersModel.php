<?php
require_once __DIR__ . '/../core/Database.php';

class UsersModel {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    /**
     * Compter le nombre total d'utilisateurs
     * @return int
     */
    public function countUsers(): int {
        try {
            $stmt = $this->pdo->query("SELECT COUNT(*) FROM users");
            return (int) $stmt->fetchColumn();
        } catch (PDOException $e) {
            // En cas d'erreur SQL, on retourne 0
            return 0;
        }
    }

    /**
     * Récupérer les derniers utilisateurs inscrits
     * @param int $limit Nombre d'utilisateurs à récupérer
     * @return array
     */
    public function getLatestUsers(int $limit = 5): array {
        // Sécurisation du paramètre
        $limit = max(1, $limit);

        $stmt = $this->pdo->prepare(
            "SELECT id, name, email, role, created_at 
             FROM users 
             ORDER BY created_at DESC 
             LIMIT :limit"
        );
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
    }

    /**
     * Récupérer tous les utilisateurs
     * @return array
     */
    public function getAllUsers(): array {
        $stmt = $this->pdo->query(
            "SELECT id, name, email, role, created_at 
             FROM users 
             ORDER BY created_at DESC"
        );
        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
    }
}