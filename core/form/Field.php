<?php

    namespace app\core\form;


    use app\core\Model;

    class Field
    {
        const TYPE_TEXT = 'text';
        const TYPE_PASSWORD = 'password';

        const TYPE_EMAIL = 'email';

        public Model $model;
        public string $attribute;
        public string $type;

        /**
         * Field constructor.
         *
         * @param Model $model
         * @param string          $attribute
         */
        public function __construct(Model $model, string $attribute , $type = null)
        {
            $this->type = $type ?? self::TYPE_TEXT;
            $this->model = $model;
            $this->attribute = $attribute;
        }

        public function __toString()
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
                $this->model->errors[$this->attribute][0] ?? null
            );
        }

    }