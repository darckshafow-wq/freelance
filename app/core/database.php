<?php
class Database {
    private $pdo;

    public function __construct() {
        $config = include __DIR__ . '/../../config/config.php';
        try {
            $dsn = "mysql:host={$config['host']};dbname={$config['dbname']};charset=utf8";
            $this->pdo = new PDO($dsn, $config['username'], $config['password']);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Erreur de connexion : " . $e->getMessage());
        }
    }

    public function getConnection() {
        return $this->pdo;
    }
}