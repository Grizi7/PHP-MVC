<?php

    namespace app\core;

    /**
     * Class Request
     *
     * Handles HTTP request data and methods.
     */
    class Request
    {
        const RULE_REQUIRED = 'required';
        const RULE_EMAIL = 'email';
        const RULE_MIN = 'min';
        const RULE_MAX = 'max';
        const RULE_MATCH = 'match';
        const RULE_UNIQUE = 'unique';


        protected array $data = [];
        protected array $errors = [];
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


        public function rules(){
            return [];
        }

        // Base validate method
        public function validate($data): bool
        {
            $this->data = $data;
            foreach ($this->rules() as $attribute => $rules) {
                $value = $data[$attribute] ?? null;
                foreach ($rules as $rule) {
                    $ruleName = is_string($rule) ? $rule : $rule[0];

                    if ($ruleName === self::RULE_REQUIRED && !$value) {
                        $this->addError($attribute, self::RULE_REQUIRED);
                    }
                    if ($ruleName === self::RULE_EMAIL && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                        $this->addError($attribute, self::RULE_EMAIL);
                    }
                    if ($ruleName === self::RULE_MIN && strlen($value) < $rule['min']) {
                        $this->addError($attribute, self::RULE_MIN, $rule);
                    }
                    if ($ruleName === self::RULE_MAX && strlen($value) > $rule['max']) {
                        $this->addError($attribute, self::RULE_MAX, $rule);
                    }
                    if ($ruleName === self::RULE_MATCH && $value !== $data[$rule['match']]) {
                        $this->addError($attribute, self::RULE_MATCH, $rule);
                    }
                    if ($ruleName === self::RULE_UNIQUE) {
                        $className = $rule['class'];
                        $uniqueAttr = $rule['attribute'] ?? $attribute;
                        $tableName = $className::$tableName;
                        $statement = Application::$app->db->prepare("SELECT * FROM $tableName WHERE $uniqueAttr = :attr");
                        $statement->bindValue(":attr", $value);
                        $statement->execute();
                        $record = $statement->fetchObject();
                        if ($record) {
                            $this->addError($attribute, self::RULE_UNIQUE, ['field' => $this->labels()[$attribute]]);
                        }
                    }
                }
            }
            return empty($this->errors);
        }

        // Method to add an error message to a specific attribute
        public function addError(string $attribute, string $rule, array $params = []): void
        {
            $message = $this->errorMessages()[$rule] ?? '';
            foreach ($params as $key => $value) {
                $message = str_replace("{{$key}}", $value, $message);
            }
            $message = str_replace(":attribute", $this->labels()[$attribute], $message);
            $this->errors[$attribute][] = $message;
        }

        // Method to return an array of error messages for validation rules
        public function errorMessages(): array
        {
            return [
                self::RULE_REQUIRED => 'The :attribute is required',
                self::RULE_EMAIL => 'The :attribute must be a valid email address',
                self::RULE_MIN => 'Min length of :attribute must be {min}',
                self::RULE_MAX => 'Max length of :attribute must be {max}',
                self::RULE_MATCH => ':attribute must be the same as {match}',
                self::RULE_UNIQUE => 'The :attribute is already taken',
            ];
        }

        // Abstract method to be implemented by child classes to return attribute labels
        public function labels(): array
        {
            return [];
        }

        // Method to get validation errors
        public function getErrors(): array
        {
            return $this->errors;
        }

        // Method to get input data
        public function input($key)
        {
            return $this->data[$key] ?? null;
        }
    }
