<?php

    use app\core\Application;
    class m_002_add_updated_at_column {
        public function up() {
            $db = Application::$app->db;
            $SQL = "ALTER TABLE users ADD COLUMN updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP";
            $db->pdo->exec($SQL);
        }

        public function down() {
            $db = Application::$app->db;
            $SQL = "ALTER TABLE users DROP COLUMN updated_at";
            $db->pdo->exec($SQL);
        }
    }