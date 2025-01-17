<?php 

    namespace app\core;

    use PDO;

    class Database {

        public PDO $pdo;
        public function __construct(array $config) {
            $dsn = $config['DB_DSN'] ?? 'mysql:host=localhost;port=3306;dbname=app';
            $user = $config['DB_USER'] ?? 'root';
            $password = $config['DB_PASSWORD'] ?? '';
            $this->pdo = new PDO($dsn, $user, $password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
    }