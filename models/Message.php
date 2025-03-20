<?php 


    namespace app\models;
    use app\core\DBModel;

    class Message extends DBModel{

        public static string $tableName = 'messages';
        const STATUS_UNREAD = 0;
        const STATUS_READ = 1;
        public string $name = '';

        public string $email = '';

        public string $subject = '';

        public int $status = self::STATUS_UNREAD;

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

        public function create() {
            $this->status = self::STATUS_UNREAD;
            return parent::create();
        }


    }