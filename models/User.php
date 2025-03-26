<?php

    namespace app\models;

    use app\core\DBModel;

    /**
     * Class User
     *
     * Represents a user model handling authentication and user data.
     */
    class User extends DBModel
    {
        /** @var string The database table name */
        public static string $tableName = 'users';

        /** @var int User status constants */
        const STATUS_INACTIVE = 0;
        const STATUS_ACTIVE = 1;
        const STATUS_DELETED = 2;

        /** @var string User attributes */
        public string $first_name = '';
        public string $last_name = '';
        public string $email = '';
        public int $status = self::STATUS_INACTIVE;
        public string $password = '';
        public string $confirm_password = '';

        /**
         * Returns the attributes stored in the database.
         *
         * @return array
         */
        public function attributes(): array
        {
            return ['first_name', 'last_name', 'email', 'status', 'password'];
        }

        /**
         * Returns field labels for forms.
         *
         * @return array
         */
        public function labels(): array
        {
            return [
                'first_name' => 'First Name',
                'last_name' => 'Last Name',
                'email' => 'Email',
                'password' => 'Password',
                'confirm_password' => 'Password Confirmation',
            ];
        }

        /**
         * Creates a new user with hashed password.
         *
         * @return mixed
         */
        public function create()
        {
            $this->status = self::STATUS_INACTIVE;
            $this->password = password_hash($this->password, PASSWORD_DEFAULT);
            return parent::create();
        }

        /**
         * Logs in a user by verifying credentials.
         *
         * @return mixed|false The user object if authenticated, false otherwise.
         */
        public function login()
        {
            $user = self::findOne(['email' => $this->email]);

            if (!$user || !password_verify($this->password, $user->password)) {
                return false;
            }

            return $user;
        }

        /**
         * Logs out the current user.
         */
        public static function logout()
        {
            sessionRemove('user');
        }
    }
