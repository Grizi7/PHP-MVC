<?php 

    namespace app\core;

    use PDO;

    /**
     * Class Database
     *
     * Manages the connection to the database and handles migrations.
     */
    class Database {

        /**
         * @var PDO $pdo The PDO instance for database interactions.
         */
        public PDO $pdo;

        /**
         * Database constructor.
         *
         * @param array $config The configuration array containing database connection details.
         */
        public function __construct(array $config) {
            $dsn = $config['DB_DSN'] ?? 'mysql:host=localhost;port=3306;dbname=app';
            $user = $config['DB_USER'] ?? 'root';
            $password = $config['DB_PASSWORD'] ?? '';
            $this->pdo = new PDO($dsn, $user, $password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }

        /**
         * Applies all pending migrations.
         *
         * @return void
         */
        public function applyMigrations(): void {
            $this->createMigrationsTable();
            $appliedMigrations = $this->getAppliedMigrations();
            $files = scandir(Application::$ROOT_DIR . '/migrations');
            $toApplyMigrations = array_diff($files, $appliedMigrations);
            $newMigrations = [];

            foreach($toApplyMigrations as $migration) {
                if($migration === '.' || $migration === '..') {
                    continue;
                }
                require_once Application::$ROOT_DIR . '/migrations/' . $migration;
                $className = pathinfo($migration, PATHINFO_FILENAME);
                $instance = new $className();
                $this->log("Applying migration $migration.");
                $instance->up();
                $this->log("Applied migration $migration.");
                $newMigrations[] = $migration;
            }

            if(!empty($newMigrations)) {
                $this->saveMigrations($newMigrations);
            } else {
                $this->log("All migrations are applied!!");
            }
        }

        /**
         * Creates the migrations table if it does not already exist.
         *
         * @return void
         */
        public function createMigrationsTable(): void {
            $this->pdo->exec("CREATE TABLE IF NOT EXISTS migrations (
                id INT AUTO_INCREMENT PRIMARY KEY,
                migration VARCHAR(255),
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP 
            ) ENGINE=INNODB;");
        }

        /**
         * Retrieves the list of already applied migrations.
         *
         * @return array The list of applied migrations.
         */
        public function getAppliedMigrations(): array {
            $statement = $this->pdo->prepare("SELECT `migration` FROM `migrations`");
            $statement->execute();
            return $statement->fetchAll(PDO::FETCH_COLUMN);
        }

        /**
         * Saves the list of newly applied migrations to the database.
         *
         * @param array $migrations The list of migration filenames to save.
         * @return void
         */
        public function saveMigrations(array $migrations): void {
            $str = implode(",", array_map(fn($m) => "('$m')", $migrations));
            $statement = $this->pdo->prepare("INSERT INTO migrations (migration) VALUES $str");
            $statement->execute();
        }

        /**
         * Prepares an SQL statement for execution.
         *
         * @param string $sql The SQL query to prepare.
         * @return \PDOStatement|false The prepared statement, or false on failure.
         */
        public function prepare(string $sql)
        {
            return $this->pdo->prepare($sql);
        }


        /**
         * Logs a message with a timestamp.
         *
         * @param string $message The message to log.
         * @return void
         */
        protected function log(string $message): void {
            echo '[' . date('Y-m-d H:i:s') . '] - ' . $message . PHP_EOL;
        }
    }
