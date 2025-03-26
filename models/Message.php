<?php

    namespace app\models;

    use app\core\DBModel;

    /**
     * Class Message
     *
     * Represents a message entity for storing user messages.
     */
    class Message extends DBModel
    {
        /** @var string The table name for the messages model */
        public static string $tableName = 'messages';

        /** @var int Status for unread messages */
        const STATUS_UNREAD = 0;

        /** @var int Status for read messages */
        const STATUS_READ = 1;

        /** @var string User's name */
        public string $name = '';

        /** @var string User's email address */
        public string $email = '';

        /** @var string Message subject */
        public string $subject = '';

        /** @var string Message content */
        public string $message = '';

        /** @var int Message status (default: unread) */
        public int $status = self::STATUS_UNREAD;

        /**
         * Returns the attributes of the Message model.
         *
         * @return array List of attributes.
         */
        public function attributes(): array
        {
            return ['name', 'email', 'subject', 'message', 'status'];
        }

        /**
         * Returns the labels for each attribute.
         *
         * @return array Attribute labels.
         */
        public function labels(): array
        {
            return [
                'name' => 'Name',
                'email' => 'Email Address',
                'subject' => 'Subject',
                'message' => 'Message',
            ];
        }

        /**
         * Saves a new message to the database with a default status of unread.
         *
         * @return bool True if message is saved successfully, false otherwise.
         */
        public function create(): bool
        {
            $this->status = self::STATUS_UNREAD;
            return parent::create();
        }
    }
