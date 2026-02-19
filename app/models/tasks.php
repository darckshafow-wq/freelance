<?php
require_once __DIR__ . '/../core/Database.php';

class Tasks {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getPdo() {
        return $this->pdo;
    }

    /**
     * Créer une nouvelle tâche
     */
    public function create(array $data): bool {
        try {
            $stmt = $this->pdo->prepare("INSERT INTO tasks 
                (user_id, title, description, price, localisation, deadline, is_permanent, status, created_at) 
                VALUES 
                (:user_id, :title, :description, :price, :localisation, :deadline, :is_permanent, 'pending', NOW())
            ");

            return $stmt->execute([
                ':user_id'     => $data['user_id'],
                ':title'       => $data['title'],
                ':description' => $data['description'],
                ':price'       => $data['price'],
                ':localisation'=> $data['localisation'],
                ':deadline'    => $data['deadline'],
                ':is_permanent'=> $data['is_permanent']
            ]);
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de la création de la tâche : " . $e->getMessage());
        }
    }

    /**
     * Récupérer toutes les tâches publiées
     */
    public function getPublishedTasks(): array {
        $stmt = $this->pdo->query("SELECT * FROM tasks WHERE status = 'published' ORDER BY created_at DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
    }

    /**
     * Récupérer toutes les tâches en attente
     */
    public function getPendingTasks(): array {
        $stmt = $this->pdo->query("SELECT * FROM tasks WHERE status = 'pending' ORDER BY created_at DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
    }

    /**
     * Compter toutes les tâches
     */
    public function countAllTasks(): int {
        $stmt = $this->pdo->query("SELECT COUNT(*) FROM tasks");
        return (int) $stmt->fetchColumn();
    }

    /**
     * Compter les tâches en attente
     */
    public function countPendingTasks(): int {
        $stmt = $this->pdo->query("SELECT COUNT(*) FROM tasks WHERE status = 'pending'");
        return (int) $stmt->fetchColumn();
    }

    /**
     * Compter les tâches publiées
     */
    public function countPublishedTasks(): int {
        $stmt = $this->pdo->query("SELECT COUNT(*) FROM tasks WHERE status = 'published'");
        return (int) $stmt->fetchColumn();
    }

    /**
     * Compter les tâches validées
     */
    public function countValidatedTasks(): int {
        $stmt = $this->pdo->query("SELECT COUNT(*) FROM tasks WHERE status = 'validated'");
        return (int) $stmt->fetchColumn();
    }

    /**
     * Récupérer une tâche par ID
     */
    public function getTaskById(int $id): ?array {
        $stmt = $this->pdo->prepare("SELECT * FROM tasks WHERE id = ?");
        $stmt->execute([$id]);
        $task = $stmt->fetch(PDO::FETCH_ASSOC);
        return $task ?: null;
    }

    /**
     * Valider une tâche
     */
    public function validate(int $id): bool {
        $stmt = $this->pdo->prepare("UPDATE tasks SET status = 'validated' WHERE id = ?");
        return $stmt->execute([$id]);
    }

    /**
     * Publier une tâche
     */
    public function publish(int $id): bool {
        $stmt = $this->pdo->prepare("UPDATE tasks SET status = 'published' WHERE id = ?");
        return $stmt->execute([$id]);
    }

    /**
     * Supprimer une tâche
     */
    public function delete(int $id): bool {
        $stmt = $this->pdo->prepare("DELETE FROM tasks WHERE id = ?");
        return $stmt->execute([$id]);
    }

    /**
     * Mettre à jour une tâche
     */
    public function update(int $id, array $data): bool {
        $stmt = $this->pdo->prepare("UPDATE tasks 
            SET title = :title, 
                description = :description, 
                price = :price, 
                localisation = :localisation, 
                deadline = :deadline, 
                is_permanent = :is_permanent 
            WHERE id = :id
        ");
        return $stmt->execute([
            ':id'          => $id,
            ':title'       => $data['title'],
            ':description' => $data['description'],
            ':price'       => $data['price'],
            ':localisation'=> $data['localisation'],
            ':deadline'    => $data['deadline'],
            ':is_permanent'=> $data['is_permanent']
        ]);
    }

    public function setStatus(int $id, string $status): bool {
        $stmt = $this->pdo->prepare("UPDATE tasks SET status = ? WHERE id = ?");
        return $stmt->execute([$status, $id]);
    }
}