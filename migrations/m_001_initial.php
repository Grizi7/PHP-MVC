<?php

    use app\core\Application;

    /**
     * Class m_001_initial
     *
     * Handles the creation and rollback of the `users` table.
     */
    class m_001_initial
    {
        /**
         * Runs the migration: creates the `users` table.
         */
        public function up()
        {
            $db = Application::$app->db;
            $SQL = "CREATE TABLE IF NOT EXISTS users (
                id INT AUTO_INCREMENT PRIMARY KEY,
                email VARCHAR(255) NOT NULL UNIQUE,
                first_name VARCHAR(255) NOT NULL,
                last_name VARCHAR(255) NOT NULL,
                password VARCHAR(512) NOT NULL,
                status TINYINT NOT NULL DEFAULT 0,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=INNODB;";
            $db->pdo->exec($SQL);
        }

        /**
         * Rolls back the migration: drops the `users` table.
         */
        public function down()
        {
            $db = Application::$app->db;
            $SQL = "DROP TABLE IF EXISTS users;";
            $db->pdo->exec($SQL);
        }
    }
