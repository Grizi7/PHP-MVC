<?php

    namespace app\core;

    /**
     * Class View
     * 
     * This class is responsible for rendering views and passing data to them.
     */

    class View{
        /**
         * @var string $title The title of the view, which can be set and used within the view templates.
         */

        public string $title = '';

        /**
         * Renders a view with a layout.
         *
         * @param string $view The name of the view.
         * @param array $params Parameters to pass to the view.
         * @return string The rendered view content.
         */
        public function renderView(string $view, array $params = []): string
        {
            $viewContent = $this->renderOnlyView($view, $params);
            $layoutContent = $this->layoutContent();

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