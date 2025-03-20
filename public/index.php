<?php


    require_once __DIR__ . "/../vendor/autoload.php";

    use app\core\Application;
    use app\controllers\SiteController;
    use app\controllers\AuthController;

    $dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
    $dotenv->load();

    $app = new Application(dirname(__DIR__), $_ENV);

    $app->router->get('/', [SiteController::class, 'home']);
    
    $app->router->get('/contact', [SiteController::class, 'contact']);
    $app->router->post('/contact', [SiteController::class, 'contact']);

    // Auth routes
    $app->router->get('/register', [AuthController::class, 'register']);
    $app->router->post('/register', [AuthController::class, 'register']);
    $app->router->get('/login', [AuthController::class, 'login']);
    $app->router->post('/login', [AuthController::class, 'login']);
    $app->router->get('/logout', [AuthController::class, 'logout']);

    $app->router->get('/profile', [AuthController::class, 'profile']);
    


    $app->run();