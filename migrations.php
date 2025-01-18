<?php

    require_once __DIR__ . "/vendor/autoload.php";

    use app\core\Application;

    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->load();

    $app = new Application(__DIR__, $_ENV);


    $app->db->applyMigrations();
