<?php 


    namespace app\models;
    use app\core\DBModel;

    class Message extends DBModel{


        public string $name = '';

        public string $email = '';

        public string $subject = '';

        public string $message = '';


        
        public function attributes(): array {
            return ['name', 'email', 'subject', 'message'];
        }

        public function labels(): array {
            return [
                'name' => 'Name',
                'email' => 'Email Address',
                'subject' => 'Subject',
                'message' => 'Message'
            ];
        }


    }