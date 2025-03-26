<?php

    use app\core\Application;

    /**
     * Class m_002_add_updated_at_column
     *
     * Adds `updated_at` column to the `users` table.
     */
    class m_002_add_updated_at_column
    {
        /**
         * Runs the migration: adds `updated_at` column.
         */
        public function up()
        {
            $db = Application::$app->db;
            $SQL = "ALTER TABLE users 
                    ADD COLUMN updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP";
            $db->pdo->exec($SQL);
        }

        /**
         * Rolls back the migration: removes `updated_at` column.
         */
        public function down()
        {
            $db = Application::$app->db;
            $SQL = "ALTER TABLE users DROP COLUMN IF EXISTS updated_at";
            $db->pdo->exec($SQL);
        }
    }
