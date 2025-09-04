<?php
class Database {
    private static ?Database $instance = null;
    private \PDO $connection;

    private function __construct() {
        $host = 'node.fauza.xyz';
        $port = 25576;
        $db   = 'Astracore';
        $user = 'remoteuser';
        $pass = 'Super123'; //Dev-only password.
        $charset = 'utf8mb4';

        $dsn = "mysql:host=$host;port=$port;dbname=$db;charset=$charset";
        $options = [
            \PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
            \PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        try {
            $this->connection = new \PDO($dsn, $user, $pass, $options);
        } catch (\PDOException $e) {
            throw new \RuntimeException('Database connection error: ' . $e->getMessage());
        }
    }

    public static function getInstance(): Database {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getConnection(): \PDO {
        return $this->connection;
    }

    private function __clone() {}
    public function __wakeup() {} // Must be public
}
