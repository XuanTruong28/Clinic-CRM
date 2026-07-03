<?php
class UserRepository {
    private PDO $db;

    public function __construct() {
        $config = require __DIR__ . '/../../config/database.php';
        $this->db = Database::connect($config);
    }

    public function findActiveByEmail(string $email): ?array {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = :email AND status = 'active' LIMIT 1");
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch();
        return $user ?: null;
    }
}