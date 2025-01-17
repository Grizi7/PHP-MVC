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
         * @return Field The generated form field.
         */
        public function field(Model $model, string $attribute, string $type = null): Field
        {
            return new Field($model, $attribute, $type);
        }
    }
