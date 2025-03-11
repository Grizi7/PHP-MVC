<?php

    namespace app\core;

    /**
     * Class Session
     *
     * Handles session management, including setting, retrieving, and flashing session messages.
     */
    class Session
    {
        protected const FLASH_KEY = 'flash_messages';

        /**
         * Session constructor.
         * Starts the session and marks flash messages for removal.
         */
        public function __construct()
        {
            session_start();

            $flashMessages = $_SESSION[self::FLASH_KEY] ?? [];
            foreach ($flashMessages as $key => &$flashMessage) {
                // Mark flash messages to be removed in the next request
                $flashMessage['remove'] = true;
            }

            $_SESSION[self::FLASH_KEY] = $flashMessages;
        }

        /**
         * Sets a session key with a given value.
         *
         * @param string $key The session key.
         * @param mixed $value The value to store.
         * @return void
         */
        public function set(string $key, $value): void
        {
            $_SESSION[$key] = $value;
        }

        /**
         * Retrieves a session value by key.
         *
         * @param string $key The session key.
         * @return mixed The session value, or false if not set.
         */
        public function get(string $key)
        {
            return $_SESSION[$key] ?? false;
        }

        /**
         * Sets a flash message in the session.
         * Flash messages are meant to be available for the next request only.
         *
         * @param string $key The flash message key.
         * @param mixed $value The message value.
         * @return void
         */
        public function setFlash(string $key, $value): void
        {
            $_SESSION[self::FLASH_KEY][$key] = [
                'remove' => false,
                'value' => $value
            ];
        }

        /**
         * Retrieves a flash message by key.
         *
         * @param string $key The flash message key.
         * @return mixed The flash message value, or false if not set.
         */
        public function getFlash(string $key)
        {
            return $_SESSION[self::FLASH_KEY][$key]['value'] ?? false;
        }

        /**
         * Removes a session key and its value.
         *
         * @param string $key The session key to remove.
         * @return void
         */
        public function remove(string $key): void
        {
            unset($_SESSION[$key]);
        }

        /**
         * Session destructor.
         * Removes flash messages that were marked for deletion.
         */
        public function __destruct()
        {
            $flashMessages = $_SESSION[self::FLASH_KEY] ?? [];
            foreach ($flashMessages as $key => &$flashMessage) {
                if ($flashMessage['remove']) {
                    unset($flashMessages[$key]);
                }
            }
            $_SESSION[self::FLASH_KEY] = $flashMessages;
        }
    }
