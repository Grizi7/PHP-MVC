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
         * Defines labels for model attributes.
         * 
         * @return array The labels for attributes.
         */
        abstract public function labels(): array;
    }
