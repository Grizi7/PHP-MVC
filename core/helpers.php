<?php

    use app\core\Application;

    /**
     * Dump and Die (dd) - Debugging function.
     *
     * @param mixed $data The data to dump.
     * @return void
     */
    function dd(mixed $data): void
    {
        echo "<pre>";
        var_dump($data);
        echo "</pre>";
        die();
    }

    /**
     * Sanitize input to prevent XSS attacks.
     *
     * @param string $data The input string.
     * @return string The sanitized string.
     */
    function sanitize(string $data): string
    {
        return htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    }

    /**
     * Redirect to a specific URL.
     *
     * @param string $url The URL to redirect to.
     * @return never
     */
    function redirect(string $url): never
    {
        header("Location: $url", true, 302);
        exit;
    }

    /**
     * Generate asset path for public files.
     *
     * @param string $path The asset file path.
     * @return string The full URL to the asset.
     */
    function asset(string $path): string
    {
        $scheme = $_SERVER['REQUEST_SCHEME'] ?? 'http';
        $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
        return "{$scheme}://{$host}/public/{$path}";
    }

    /**
    * Render a view file with optional parameters.
    *
    * @param string $view The view filename.
    * @param array $params Associative array of parameters.
    * @return string The rendered HTML.
    */
    function view(string $view, array $params = []): string
    {
        extract($params, EXTR_SKIP); // Prevents overwriting built-in variables
        ob_start();
        include_once Application::$ROOT_DIR . "/views/{$view}.php";
        return ob_get_clean();
    }

    /**
    * Get the authenticated user.
    *
    * @return mixed The user instance or null if not authenticated.
    */
    function user(): mixed
    {
        return Application::$app->user ?? null;
    }

    /**
    * Check if the current user is a guest.
    *
    * @return bool True if guest, false if authenticated.
    */
    function isGuest(): bool
    {
        return user() === null;
    }

    /**
    * Set a session variable.
    *
    * @param string $key The session key.
    * @param mixed $value The value to store.
    * @return void
    */
    function sessionSet(string $key, mixed $value): void
    {
        Application::$app->session->set($key, $value);
    }

    /**
    * Get a session variable.
    *
    * @param string $key The session key.
    * @return mixed The stored value or null.
    */
    function sessionGet(string $key): mixed
    {
        return Application::$app->session->get($key);
    }

    /**
    * Remove a session variable.
    *
    * @param string $key The session key.
    * @return void
    */
    function sessionRemove(string $key): void
    {
        Application::$app->session->remove($key);
    }

    /**
    * Get a flashed session message.
    *
    * @param string $key The session flash key.
    * @return mixed The flash message or null.
    */
    function sessionFlashGet(string $key): mixed
    {
        return Application::$app->session->getFlash($key);
    }

    /**
    * Set a flash message in session.
    *
    * @param string $key The session flash key.
    * @param string $message The message to store.
    * @return void
    */
    function sessionFlashSet(string $key, string $message): void
    {
        Application::$app->session->setFlash($key, $message);
    }
