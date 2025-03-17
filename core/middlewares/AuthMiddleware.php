<?php

    namespace app\core\middlewares;

    use app\core\Application;
    use app\core\exceptions\ForbiddenException;

    /**
     * Class AuthMiddleware
     *
     * Handles the logic for checking if a user is authenticated.
     */
    class AuthMiddleware extends BaseMiddleware
    {

        public array $actions = [];
        /**
         * AuthMiddleware constructor.
         *
         * Initializes the middleware.
         */
        public function __construct(array $actions = [])
        {
            $this->actions = $actions;
        }

        /**
         * Checks if the user is authenticated.
         *
         * @param array $actions The actions that require authentication.
         * @return void
         * @throws ForbiddenException If the user is not authenticated.
         */
        public function execute()
        {
            if (isGuest()) {
                if (empty($this->actions) || in_array(Application::$app->controller->action, $this->actions)) {
                    throw new ForbiddenException();
                }
            }
        }
    }