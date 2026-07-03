<?php
class Database {
    public static function connect(array $config): PDO {
        $dsn = sprintf(
            'mysql:host=%s;dbname=%s;charset=%s',
            $config['host'],
            $config['dbname'],
            $config['charset']
        );

        try {
            return new PDO($dsn, $config['username'], $config['password'], [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ]);
        } catch (PDOException $e) {
            log_error("Database Connection Failed: " . $e->getMessage());
            die("Lỗi kết nối CSDL. Chi tiết lỗi: " . $e->getMessage()); 
        }
    }
}