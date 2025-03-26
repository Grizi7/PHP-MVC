<?php

    use app\core\Application;

    /**
     * Class m_003_messages
     *
     * Creates the `messages` table to store user messages.
     */
    class m_003_messages
    {
        /**
         * Runs the migration: creates the `messages` table.
         */
        public function up()
        {
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

        /**
         * Rolls back the migration: removes the `messages` table.
         */
        public function down()
        {
            $db = Application::$app->db;
            $SQL = "DROP TABLE IF EXISTS messages";
            $db->pdo->exec($SQL);
        }
    }
