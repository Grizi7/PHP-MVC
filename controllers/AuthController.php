<?php 



    namespace app\controllers;

    use app\core\Controller;
    use app\core\Request;
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
         * @return string The rendered view or a message upon form submission.
         */
        public function register(Request $request): string
        {
            $user = new User();
            if ($request->isPost()) {
                $user->loadData($request->getBody());
            
                if ($user->validate() && $user->create()) {
                    return 'Success';
                }

            }
            return $this->render('register', [
                'model' => $user,
                'form' => new Form(),
            ]);
        }
    }
