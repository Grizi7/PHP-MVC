<?php

    namespace app\core;

    /**
     * Class Request
     *
     * Handles HTTP request data and methods.
     */
    class Request
    {
        /**
         * Retrieves the path from the URL.
         *
         * @return string The path without the query string.
         */
        public function getPath(): string
        {
            $path = $_SERVER['REQUEST_URI'] ?? '/';
            $position = strpos($path, '?');
            if ($position === false) {
                return $path;
            }
            return substr($path, 0, $position);
        }

        /**
         * Retrieves the HTTP method of the request.
         *
         * @return string The HTTP method in lowercase (e.g., "get", "post").
         */
        public function method(): string
        {
            return strtolower($_SERVER['REQUEST_METHOD']);
        }

        /**
         * Checks if the request method is GET.
         *
         * @return bool True if the method is GET, otherwise false.
         */
        public function isGet(): bool
        {
            return $this->method() === 'get';
        }

        /**
         * Checks if the request method is POST.
         *
         * @return bool True if the method is POST, otherwise false.
         */
        public function isPost(): bool
        {
            return $this->method() === 'post';
        }

        /**
         * Retrieves the sanitized input data from the request body.
         *
         * @return array An associative array of sanitized input data.
         */
        public function getBody(): array
        {
            $body = [];
            if ($this->method() === 'get') {
                foreach ($_GET as $key => $value) {
                    $body[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
                }
            }
            if ($this->method() === 'post') {
                foreach ($_POST as $key => $value) {
                    $body[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
                }
            }
            return $body;
        }
    }
