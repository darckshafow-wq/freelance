<?php
require_once __DIR__ . '/app/core/Database.php';

try {
    $db = new Database();
    $pdo = $db->getConnection();

    $sql = "CREATE TABLE IF NOT EXISTS applications (
        id INT AUTO_INCREMENT PRIMARY KEY,
        task_id INT NOT NULL,
        freelance_id INT NOT NULL,
        message TEXT,
        bid_price DECIMAL(10,2),
        status ENUM('pending', 'accepted', 'rejected') DEFAULT 'pending',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (task_id) REFERENCES tasks(id) ON DELETE CASCADE,
        FOREIGN KEY (freelance_id) REFERENCES users(id) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

    $pdo->exec($sql);
    echo "Table 'applications' created successfully.";

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
