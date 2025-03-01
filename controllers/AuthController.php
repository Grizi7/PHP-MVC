<?php

    namespace app\controllers;

    use app\core\Application;
    use app\core\Controller;
    use app\core\Request;
    use app\core\Response;
    use app\core\form\Form;
    use app\models\User;

    /**
     * Class AuthController
     *
     * Handles authentication-related actions such as login and registration.
     */
    class AuthController extends Controller
    {
        /**
         * AuthController constructor.
         *
         * Sets the layout for authentication views.
         */
        public function __construct()
        {
            $this->setLayout('auth');
        }

        /**
         * Handles the login functionality.
         *
         * @param Request $request The HTTP request instance.
         * @return string The rendered view or a message upon form submission.
         */
        public function login(Request $request): string
        {
            if ($request->isPost()) {
                return "Handle submitted data";
            }
            return $this->render('login');
        }

        /**
         * Handles the registration functionality.
         *
         * @param Request $request The HTTP request instance.
         * @param Response $response The HTTP response instance.
         * @return string The rendered view or redirects upon successful registration.
         */
        public function register(Request $request, Response $response): string
        {
            $user = new User();

            if ($request->isPost()) {
                $user->loadData($request->getBody());

                if ($user->validate() && $user->create()) {
                    Application::$app->session->setFlash('success', 'Thanks for registering!');
                    $response->redirect('/home');
                    return ''; // No need to continue execution after redirect
                }
            }

            return $this->render('register', [
                'model' => $user,
                'form' => new Form(),
            ]);
        }
    }
