<?php

    namespace app\core;

    /**
     * Class Model
     * 
     * This abstract class serves as a base model for handling validation rules,
     * data loading, and error handling for form validation.
     */
    abstract class Model
    {
        public const RULE_REQUIRED = 'required';
        public const RULE_EMAIL = 'email';
        public const RULE_MIN = 'min';
        public const RULE_MAX = 'max';
        public const RULE_MATCH = 'match';
        public const RULE_UNIQUE = 'unique';

        /** @var array Stores validation errors */
        public array $errors = [];

        /**
         * Loads data into the model's properties.
         * 
         * @param array $data Associative array of data to load into the model.
         * @return void
         */
        public function loadData(array $data): void
        {
            foreach ($data as $key => $value) {
                if (property_exists($this, $key)) {
                    $this->{$key} = $value;
                }
            }
        }

        /**
         * Defines validation rules for model attributes.
         * 
         * @return array The validation rules for attributes.
         */
        abstract public function rules(): array;

        /**
         * Defines labels for model attributes.
         * 
         * @return array The labels for attributes.
         */
        abstract public function labels(): array;

        /**
         * Validates the model data against defined rules.
         * 
         * @return bool True if validation passes, false otherwise.
         */
        public function validate(): bool
        {
            foreach ($this->rules() as $attribute => $rules) {
                $value = $this->{$attribute};
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
                    if ($ruleName === self::RULE_MATCH && $value !== $this->{$rule['match']}) {
                        $this->addError($attribute, self::RULE_MATCH, $rule);
                    }
                    if ($ruleName === self::RULE_UNIQUE) {
                        $className = $rule['class'];
                        $uniqueAttr = $rule['attribute'] ?? $attribute;
                        $tableName = $className::tableName();
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

        /**
         * Adds an error message to a specific attribute.
         * 
         * @param string $attribute The attribute name.
         * @param string $rule The validation rule that failed.
         * @param array $params Additional parameters for the error message.
         * @return void
         */
        public function addError(string $attribute, string $rule, array $params = []): void
        {
            $message = $this->errorMessages()[$rule] ?? '';
            foreach ($params as $key => $value) {
                $message = str_replace("{{$key}}", $value, $message);
            }
            $message = str_replace(":attribute", $this->labels()[$attribute], $message);
            $this->errors[$attribute][] = $message;
        }

        /**
         * Returns an array of error messages for validation rules.
         * 
         * @return array The validation error messages.
         */
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
    }
