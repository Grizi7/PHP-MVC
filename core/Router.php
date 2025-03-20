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
                return Application::$app->view->renderView($callback);
            }

            if (is_array($callback)) {
                $controller = new $callback[0]();
                Application::$app->controller = $controller; 
                $controller->action = $callback[1];
                foreach ($controller->getMiddlewares() as $middleware) {
                    $middleware->execute();
                }
                $callback[0] = $controller;
            }

            return call_user_func($callback, $this->request);
        }


        
    }
