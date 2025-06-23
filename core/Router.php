<?php


    namespace app\core;
    use ReflectionMethod;

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
            $requestClass = is_array($callback)
                ? $this->resolveDependencies($callback[0], $callback[1])[0] ?? $this->request : $this->request;
            return call_user_func($callback, $requestClass);
        }


        /**
         * Resolves and injects dependencies for a controller method.
         *
         * This method uses reflection to analyze the parameters of the specified
         * controller method and resolves any dependencies, such as subclasses of
         * the Request class, to be injected when the method is called.
         *
         * @param string|object $controller The controller instance or class name.
         * @param string $method The method name within the controller.
         * @return array The resolved dependencies to be injected.
         */
        public function resolveDependencies($controller, $method): array
        {
            $reflection = new ReflectionMethod($controller, $method);
            $parameters = $reflection->getParameters();

            $dependencies = [];

            foreach ($parameters as $parameter) {
                $type = $parameter->getType();

                if ($type && !$type->isBuiltin()) {

                    $className = $type->getName();

                    if (is_subclass_of($className, Request::class)) {
                        $dependencies[] = new $className($this->request); 
                        continue;
                    }
                }
            }

            return $dependencies;
        }

        
    }
