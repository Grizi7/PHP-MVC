<?php

    namespace app\core\form;

    /**
     * Class TextareaField
     *
     * Represents a textarea input field in a form.
     */
    class TextareaField extends BaseField
    {
        /**
         * TextareaField constructor.
         *
         * @param object $model The model instance.
         * @param string $attribute The attribute name.
         */
        public function __construct(object $model, string $attribute)
        {
            parent::__construct($model, $attribute);
        }

        /**
         * Render the input field as a textarea.
         *
         * @return string The HTML markup for the textarea field.
         */
        public function renderInput(): string
        {
            // Escape attribute name and value to prevent XSS
            $attribute = htmlspecialchars($this->attribute, ENT_QUOTES, 'UTF-8');
            $value = htmlspecialchars($this->model->{$this->attribute} ?? '', ENT_QUOTES, 'UTF-8');
            $invalidClass = isset($this->model->errors[$this->attribute]) ? ' is-invalid' : '';

            return sprintf(
                '<textarea name="%s" class="form-control%s">%s</textarea>',
                $attribute,
                $invalidClass,
                $value
            );
        }
    }

