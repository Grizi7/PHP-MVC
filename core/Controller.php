<?php


    namespace app\core;
    
    use app\core\middlewares\BaseMiddleware;
    /**
     * Class Controller
     *
     * Handles the logic for rendering views and managing layouts.
     */
    class Controller
    {
        /**
         * @var string $layout The layout to be used for rendering views.
         */
        public string $layout = 'main';
        public string $action = '';
        protected array $middlewares = [];
        /**
         * Sets the layout to be used for rendering views.
         *
         * @param string $layout The name of the layout.
         * @return void
         */
        public function setLayout(string $layout): void
        {
            $this->layout = $layout;
        }

        /**
         * Renders a view with the given parameters.
         *
         * @param string $view The name of the view to render.
         * @param array $params The parameters to pass to the view.
         * @return string The rendered view content.
         */
        public function render(string $view, array $params = []): string
        {
            return Application::$app->view->renderView($view, $params);
        }


        public function registerMiddleware(BaseMiddleware $middleware)
        {
            $this->middlewares[] = $middleware;
        }


        public function getMiddlewares(): array
        {
            return $this->middlewares;
        }
    }
