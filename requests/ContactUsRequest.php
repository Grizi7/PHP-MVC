<?php

    namespace app\requests;

    use app\core\Request;
    
    /**
     * Class ContactUs
     * 
     * This class handles the ContactUs form data.
     */
    class ContactUsRequest extends Request
    {
        public string $name = '';
        public string $email = '';
        public string $subject = '';
        public string $message = '';

        /**
         * Retrieves the rules for the ContactUs form.
         * 
         * @return array The rules for the ContactUs form.
         */
        public function rules(): array
        {
            return [
                'name' => [self::RULE_REQUIRED, [self::RULE_MIN, 'min' => 2], [self::RULE_MAX, 'max' => 24]],
                'email' => [self::RULE_REQUIRED, self::RULE_EMAIL],
                'subject' => [self::RULE_REQUIRED, [self::RULE_MIN, 'min' => 8], [self::RULE_MAX, 'max' => 24]],
                'message' => [self::RULE_REQUIRED],
            ];
        }

        /**
         * Retrieves the labels for the ContactUs form.
         * 
         * @return array The labels for the ContactUs form.
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
    }