<?php

    namespace app\models;

    use app\core\DBModel;

    class User extends DBModel
    {
        const STATUS_INACTIVE = 0;
        const STATUS_ACTIVE = 1;
        const STATUS_DELETED = 2;

        public string $first_name = '';
        public string $last_name = '';
        public string $email = '';
        public int $status = self::STATUS_INACTIVE;
        public string $password = '';
        public string $confirm_password = '';

        public function tableName(): string
        {
            return 'users';
        }

        public function attributes(): array
        {
            return ['first_name', 'last_name', 'email', 'status', 'password'];
        }
        public function create()
        {
            // create a new user in the database
            $this->status = self::STATUS_INACTIVE;
            $this->password = password_hash($this->password, PASSWORD_DEFAULT);
            return parent::create();
            
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