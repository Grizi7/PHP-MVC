<?php

    namespace app\core\form;

    use app\core\Model;

    /**
     * Class Field
     *
     * Represents a form field and generates HTML for it dynamically.
     */
    class Field
    {
        const TYPE_TEXT = 'text';
        const TYPE_PASSWORD = 'password';
        const TYPE_EMAIL = 'email';

        /** @var Model $model The model associated with the field. */
        public Model $model;

        /** @var string $attribute The attribute name of the model for this field. */
        public string $attribute;

        /** @var string $type The input type for the field. */
        public string $type;

        /**
         * Field constructor.
         *
         * @param Model $model The model associated with the field.
         * @param string $attribute The attribute name of the model for this field.
         * @param string|null $type The input type for the field, defaults to 'text'.
         */
        public function __construct(Model $model, string $attribute, $type = null)
        {
            $this->type = $type ?? self::TYPE_TEXT;
            $this->model = $model;
            $this->attribute = $attribute;
        }

        /**
         * Generates the HTML string representation of the form field.
         *
         * @return string The HTML string for the form field.
         */
        public function __toString(): string
        {
            $template = '
                <div class="form-group">
                    <label>%s</label>
                    <input type="%s" class="form-control %s" name="%s" value="%s">
                    <div class="invalid-feedback">
                        %s
                    </div>
                </div>
            ';

            return sprintf(
                $template,
                $this->model->labels()[$this->attribute] ?? $this->attribute,
                $this->type,
                isset($this->model->errors[$this->attribute]) ? ' is-invalid' : '',
                $this->attribute,
                $this->model->{$this->attribute},
                $this->model->errors[$this->attribute][0] ?? ''
            );
        }
    }
