<?php 

    namespace app\core\form;
    use app\core\Model;
    abstract class BaseField{

        const TYPE_TEXT = 'text';
        const TYPE_PASSWORD = 'password';
        const TYPE_EMAIL = 'email';


        /** @var Model $model The model associated with the field. */
        public Model $model;

        /** @var string $attribute The attribute name of the model for this field. */
        public string $attribute;

        /** @var string $type The type of the input field. */
        public string $type;

        /**
         * Field constructor.
         *
         * @param Model $model The model associated with the field.
         * @param string $attribute The attribute name of the model for this field.
        */
        public function __construct(Model $model, string $attribute)
        {
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
                        %s
                        <div class="invalid-feedback">
                            %s
                        </div>
                    </div>
                ';

            return sprintf(
                $template,
                $this->model->labels()[$this->attribute] ?? $this->attribute,
                $this->renderInput(),
                $this->model->errors[$this->attribute][0] ?? ''
            );
        }
        abstract public function renderInput(): string;

    }