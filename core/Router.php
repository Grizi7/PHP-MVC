<?php

    namespace app\core;

    /**
     * Class Router
     *
     * Handles routing of HTTP requests and rendering of views.
     */
    class Router
    {
        /** @var Request $request The HTTP request instance. */
        public Request $request;

        /** @var Response $response The HTTP response instance. */
        public Response $response;

        /** @var array $routes Registered routes for the application. */
        protected array $routes = [];

        /**
         * Router constructor.
         *
         * @param Request $request The HTTP request instance.
         * @param Response $response The HTTP response instance.
         */
        public function __construct(Request $request, Response $response)
        {
            $this->request = $request;
            $this->response = $response;
        }

        /**
         * Registers a GET route.
         *
         * @param string $path The route path.
         * @param mixed $callback The callback to handle the route.
         * @return void
         */
        public function get(string $path, $callback): void
        {
            $this->routes['get'][$path] = $callback;
        }

        /**
         * Registers a POST route.
         *
         * @param string $path The route path.
         * @param mixed $callback The callback to handle the route.
         * @return void
         */
        public function post(string $path, $callback): void
        {
            $this->routes['post'][$path] = $callback;
        }

        /**
         * Resolves the current request by matching it to a route.
         *
         * @return string The resolved output or view content.
         */
        public function resolve(): string
        {
            $path = $this->request->getPath();
            $method = $this->request->method();
            $callback = $this->routes[$method][$path] ?? false;
        
            if ($callback == false) {
                $this->response->setStatusCode(404);
                return view("_404");
            }

            if (is_string($callback)) {
                return $this->renderView($callback);
            }

            if (is_array($callback)) {
                Application::$app->controller = new $callback[0]();
                $callback[0] = Application::$app->controller;
            }

            return call_user_func($callback, $this->request);
        }


        /**
         * Renders a view with a layout.
         *
         * @param string $view The name of the view.
         * @param array $params Parameters to pass to the view.
         * @return string The rendered view content.
         */
        public function renderView(string $view, array $params = []): string
        {
            $layoutContent = $this->layoutContent();
            $viewContent = $this->renderOnlyView($view, $params);

            return str_replace('{{content}}', $viewContent, $layoutContent);
        }

        /**
         * Retrieves the layout content.
         *
         * @return string The layout content.
         */
        protected function layoutContent(): string
        {
            $layout = Application::$app->controller->layout;
            ob_start();
            include_once Application::$ROOT_DIR . "/views/layouts/$layout.php";
            return ob_get_clean();
        }

        /**
         * Renders the content of a specific view.
         *
         * @param string $view The name of the view.
         * @param array $params Parameters to pass to the view.
         * @return string The rendered view content.
         */
        protected function renderOnlyView(string $view, array $params): string
        {
            foreach ($params as $key => $value) {
                $$key = $value;
            }
            ob_start();
            include_once Application::$ROOT_DIR . "/views/$view.php";
            return ob_get_clean();
        }
    }
