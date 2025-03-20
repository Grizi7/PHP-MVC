<?php 


    use app\core\Application;
    class m_003_messages {
        public function up() {
            
            $db = Application::$app->db;
            $SQL = "CREATE TABLE messages (
                id INT AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(255) NOT NULL,
                email VARCHAR(255) NOT NULL,
                subject VARCHAR(255) NOT NULL,
                message TEXT NOT NULL,
                status TINYINT DEFAULT 0 NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=INNODB;";
            $db->pdo->exec($SQL);
        }

        public function down() {
            $db = Application::$app->db;
            $SQL = "DROP TABLE message";
            $db->pdo->exec($SQL);
        }
    }