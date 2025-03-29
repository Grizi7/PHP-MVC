<?php

    namespace app\core\form;

    use app\core\Model;

    /**
     * Class InputField
     *
     * Represents a form input field and generates HTML dynamically.
     */
    class InputField extends BaseField
    {

        /**
         * InputField constructor.
         *
         * @param Model $model The model associated with the field.
         * @param string $attribute The attribute name of the model for this field.
         */
        public function __construct(Model $model, string $attribute, string $type)
        {
            $this->type = self::TYPE_TEXT;
            parent::__construct($model, $attribute, $type);
        }

        /**
         * Sets the input type.
         *
         * @param string $type The input type (text, password, email, etc.).
         * @return $this
         */
        public function setType(string $type): self
        {
            $this->type = $type;
            return $this;
        }

        /**
         * Generates the HTML for the input field.
         *
         * @return string The rendered input field.
         */
        public function renderInput(): string
        {
            return sprintf(
                '<input type="%s" name="%s" value="%s" class="form-control%s">',
                htmlspecialchars($this->type, ENT_QUOTES, 'UTF-8'),
                htmlspecialchars($this->attribute, ENT_QUOTES, 'UTF-8'),
                htmlspecialchars($this->model->{$this->attribute} ?? '', ENT_QUOTES, 'UTF-8'),
                isset($this->model->errors[$this->attribute]) ? ' is-invalid' : ''
            );
        }
    }
