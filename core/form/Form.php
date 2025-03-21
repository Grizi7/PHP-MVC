<?php

    namespace app\core\form;

    use app\core\Model;

    /**
     * Class Form
     *
     * Provides functionality to generate and manage HTML forms.
     */
    class Form
    {
        /**
         * Begins an HTML form.
         *
         * @param string $action The form action URL.
         * @param string $method The form submission method (e.g., 'post' or 'get').
         * @return void
         */
        public static function begin(string $action, string $method): void
        {
            echo "<form action='$action' method='$method'>";
        }

        /**
         * Ends an HTML form and includes a submit button.
         *
         * @return void
         */
        public static function end(): void
        {
            echo "
                    <button type='submit' class='btn btn-primary mt-2'>Submit</button>
                </form>
            ";
        }

        /**
         * Creates a form field.
         *
         * @param Model $model The model associated with the form field.
         * @param string $attribute The attribute name for the field.
         * @param string|null $type The type of the input field (e.g., 'text', 'email').
         * @return InputField The generated form field.
         */
        public function field(Model $model, string $attribute, string $type = null): InputField
        {
            return new InputField($model, $attribute, $type);
        }

        /**
         * Creates a textarea field.
         *
         * @param Model $model The model associated with the form field.
         * @param string $attribute The attribute name for the field.
         * @return TextareaField The generated textarea field.
         */
        public function textareaField(Model $model, string $attribute): TextareaField
        {
            return new TextareaField($model, $attribute);
        }
    }
