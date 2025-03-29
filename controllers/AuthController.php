<?php



    namespace app\controllers;

    use app\core\Controller;
    use app\core\Request;
    use app\core\form\Form;
    use app\models\User;
    use app\requests\RegisterRequest;
    use app\requests\LoginRequest;
    use app\core\middlewares\AuthMiddleware;

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
            $this->registerMiddleware(new AuthMiddleware(['profile']));
        }

        /**
         * Handles the login functionality.
         *
         * @param LoginRequest $request The HTTP request instance.
         * @return string The rendered view or a message upon form submission.
         */
        public function login(LoginRequest $request): string
        {
            $user = new User();

            if ($request->isPost()) {
                
                $data = $request->getBody();

                // Validate the request
                
                $validation = $request->validate($data);
                
                $user->email = $request->input('email');
                $user->password = $request->input('password');
                if (!$validation) {
                    $user->errors = $request->getErrors();   
                }else{

                    $loginAttempt = $user->login();
                    
                    if($loginAttempt){
                        sessionFlashSet('success', 'Welcome back!');
                        sessionSet('user', $loginAttempt);
                        redirect('/');
                    } else {
                        sessionFlashSet('error', 'Invalid login credentials');
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
        public function register(RegisterRequest $request)
        {
            $user = new User();

            if ($request->isPost()) {

                $data = $request->getBody();

                // Validate the request
                
                $validation = $request->validate($data);
                
                $user->first_name = $request->input('first_name');
                $user->last_name = $request->input('last_name');
                $user->email = $request->input('email');
                
                if (!$validation) {
                    $user->errors = $request->getErrors();   
                }else{
                    $user->password = (empty($user->errors)) ? $request->input('password') : '';
                    $user->create();
                    sessionFlashSet('success', 'Thanks for registering!');
                    redirect('/');
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
            redirect('/');
        }

        /**
         * Displays the user profile.
         *
         * @return string The rendered view.
         */
        public function profile(): string
        {
            $this->setLayout('main');
            $user = sessionGet('user');
            return $this->render('profile', [
                'user' => $user,
            ]);
        }
    }
