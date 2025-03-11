<?php

    namespace app\requests;

    use app\core\Request;
    use app\models\User;

    /**
     * Class RegisterRequest
     * 
     * This class handles the registration form data.
     */
    class RegisterRequest extends Request
    {
        public string $first_name = '';
        public string $last_name = '';
        public string $email = '';
        public string $password = '';
        public string $confirm_password = '';

        /**
         * Retrieves the rules for the registration form.
         * 
         * @return array The rules for the registration form.
         */
        public function rules(): array
        {
            return [
                'first_name' => [self::RULE_REQUIRED, [self::RULE_MIN, 'min' => 2], [self::RULE_MAX, 'max' => 24]],
                'last_name' => [self::RULE_REQUIRED, [self::RULE_MIN, 'min' => 2], [self::RULE_MAX, 'max' => 24]],
                'email' => [self::RULE_REQUIRED, self::RULE_EMAIL, [self::RULE_UNIQUE, 'class' => User::class]],
                'password' => [self::RULE_REQUIRED, [self::RULE_MIN, 'min' => 8], [self::RULE_MAX, 'max' => 24]],
                'confirm_password' => [self::RULE_REQUIRED, [self::RULE_MATCH, 'match' => 'password']],
            ];
        }

        /**
         * Retrieves the labels for the registration form.
         * 
         * @return array The labels for the registration form.
         */
        public function labels(): array
        {
            return [
                'first_name' => 'First Name',
                'last_name' => 'Last Name',
                'email' => 'Email',
                'password' => 'Password',
                'confirm_password' => 'Confirm Password',
            ];
        }
    }