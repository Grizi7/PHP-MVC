<?php


    namespace app\controllers;

    use app\core\Application;
    use app\core\Controller;
    use app\core\Request;
    use app\core\form\Form;
    use app\models\User;
    use app\requests\RegisterRequest;
    use app\requests\LoginRequest;

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
            $user = new User();
            if ($request->isPost()) {
                $data = $request->getBody();
                
                $loginRequest = new LoginRequest();

                // Validate the request
                
                $validation = $loginRequest->validate($data);
                
                $user->email = $loginRequest->input('email');
                $user->password = $loginRequest->input('password');
                if (!$validation) {
                    $user->errors = $loginRequest->getErrors();   
                }else{
                    $user->password = (empty($user->errors)) ? $loginRequest->input('password') : '';
                    $user = $user->login();
                    if($user){
                        Application::$app->session->setFlash('success', 'Thanks for logining!');
                        Application::$app->session->set('user', $user);
                        Application::$app->response->redirect('/home');
                    } else {
                        Application::$app->session->setFlash('error', 'Invalid login credentials');
                    }
                }
            }
            return $this->render('login', [
                'model' => $user,
                'form' => new Form(),
            ]);
        }

        /**
         * Handles the registration functionality.
         *
         * @param RegisterRequest $request The HTTP request instance.
         * @return string The rendered view or redirects upon successful registration.
         */
        public function register(Request $request)
        {
            $user = new User();

            if ($request->isPost()) {

                $data = $request->getBody();
                $registerRequest = new RegisterRequest();

                // Validate the request
                
                $validation = $registerRequest->validate($data);
                
                $user->first_name = $registerRequest->input('first_name');
                $user->last_name = $registerRequest->input('last_name');
                $user->email = $registerRequest->input('email');
                
                if (!$validation) {
                    $user->errors = $registerRequest->getErrors();   
                }else{
                    $user->password = (empty($user->errors)) ? $registerRequest->input('password') : '';
                    $user->create();
                    Application::$app->session->setFlash('success', 'Thanks for registering!');
                    Application::$app->response->redirect('/home');
                }

            }

            return $this->render('register', [
                'model' => $user,
                'form' => new Form(),
            ]);
        }

        /**
         * Logs out the current user.
         */
        public function logout(): void
        {
            User::logout();
            sessionFlashSet('success', 'Successfully logged out');
            redirect('/home');
        }
    }
