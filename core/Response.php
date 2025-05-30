<?php

    namespace app\core;

    /**
     * Class Response
     *
     * Handles HTTP response functionalities.
     */
    class Response
    {
        /**
         * Sets the HTTP status code for the response.
         *
         * @param int $code The HTTP status code to set.
         * @return void
         */
        public function setStatusCode(int $code): void
        {
            http_response_code($code);
        }

        /**
         * Redirects the user to the specified URL.
         *
         * @param string $url The URL to redirect to.
         * @return void
         */
        public function redirect(string $url): void {
            header('Location: ' . $url);
        }
    }
