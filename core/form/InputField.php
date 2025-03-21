<?php

    namespace app\core\form;

    use app\core\Model;

    /**
     * Class InputField
     *
     * Represents a form field and generates HTML for it dynamically.
     */
    class InputField extends BaseField
    {
        const TYPE_TEXT = 'text';
        const TYPE_PASSWORD = 'password';
        const TYPE_EMAIL = 'email';

        /** @var string $type The input type for the field. */
        public string $type = self::TYPE_TEXT;
        
        /**
         * Field constructor.
         *
         * @param Model $model The model associated with the field.
         * @param string $attribute The attribute name of the model for this field.
         * @param string $type The input type for the field.
         */

        public function __construct(Model $model, string $attribute)
        {
            $this->type = self::TYPE_TEXT;
            parent::__construct($model, $attribute);
        }

        public function renderInput(): string
        {
            return sprintf(
                '<input type="%s" name="%s" value="%s" class="form-control%s">',
            
                $this->type,
                $this->attribute,
                $this->model->{$this->attribute},
                isset($this->model->errors[$this->attribute]) ? ' is-invalid' : '',
            );
        }
    }
