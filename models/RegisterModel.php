<?php

    namespace app\models;

    use app\core\Model;

    class RegisterModel extends Model
    {

        public string $first_name = '';
        public string $last_name = '';
        public string $email = '';
        public string $password = '';
        public string $confirm_password = '';

        public function save()
        {
            // create a new user in the database

            return true;
        }

        public function rules(): array
        {
            return [
                'first_name' => [self::RULE_REQUIRED , [self::RULE_MIN, 'min' => 2], [self::RULE_MAX, 'max' => 24]],
                'last_name' => [self::RULE_REQUIRED, [self::RULE_MIN, 'min' => 2], [self::RULE_MAX, 'max' => 24]],
                'email' => [self::RULE_REQUIRED, self::RULE_EMAIL],
                'password' => [self::RULE_REQUIRED, [self::RULE_MIN, 'min' => 8], [self::RULE_MAX, 'max' => 24]],
                'confirm_password' => [self::RULE_REQUIRED, [self::RULE_MATCH, 'match' => 'password']],
            ];
        }

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


    }