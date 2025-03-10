<?php

    namespace app\core;

    /**
     * Class Application
     *
     * The core application class that manages the lifecycle and components of the app.
     */
    class Application
    {
        /** @var string The root directory of the application. */
        public static string $ROOT_DIR;

        /** @var Application The singleton instance of the application. */
        public static Application $app;

        /** @var Request The HTTP request instance. */
        public Request $request;

        /** @var Response The HTTP response instance. */
        public Response $response;

        /** @var Router The router instance for managing routes. */
        public Router $router;

        /** @var Database The singleton instance of the database. */
        public Database $db;

        /** @var Session The session instance for managing user sessions. */
        public Session $session;

        /** @var Controller|null The current controller handling the request. */
        public ?Controller $controller = null;

        /** @var  */

        public ?DBModel $user;

        /**
         * Application constructor.
         *
         * @param string $rootPath The root directory path of the application.
         * @param array $config The configuration array for the application.
         */
        public function __construct(string $rootPath, array $config)
        {
            self::$ROOT_DIR = $rootPath;
            self::$app = $this;

            $this->request = new Request();
            $this->response = new Response();
            $this->session = new Session();
            $this->router = new Router($this->request, $this->response);
            $this->db = new Database($config);
            if($this->session->get('user')){
                $this->user = $this->session->get('user'); 
            } 
        }

        /**
         * Runs the application by resolving the current route.
         */
        public function run(): void
        {
            echo $this->router->resolve();
        }

        /**
         * Gets the current controller instance.
         *
         * @return Controller|null The current controller or null if none is set.
         */
        public function getController(): ?Controller
        {
            return $this->controller;
        }

        /**
         * Sets the current controller instance.
         *
         * @param Controller $controller The controller instance to set.
         * @return self The current application instance.
         */
        public function setController(Controller $controller): self
        {
            $this->controller = $controller;
            return $this;
        }
    }
