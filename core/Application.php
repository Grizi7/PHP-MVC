<?php
    namespace app\core;
    class Application{

        public static string $ROOT_DIR;
        public Request $request;

        public Response $response;
        public Router $router;

        public static Application $app;

        public Controller $controller;
        
        public function __construct(string $rootPath){

            self::$ROOT_DIR = $rootPath;
            self::$app = $this;

            $this->request = new Request();
            $this->response = new Response();

            $this->router = new Router($this->request, $this->response);

        }

        public function run(){
            echo $this->router->resolve();
        }

        /**
         * Get the value of controller
         */ 
        public function getController()
        {
            return $this->controller;
        }

        /**
         * Set the value of controller
         *
         * @return  self
         */ 
        public function setController($controller)
        {
            $this->controller = $controller;

            return $this;
        }
    }