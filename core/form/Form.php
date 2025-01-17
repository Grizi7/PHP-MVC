<?php

    namespace app\core\form;

    class Form{
        public static function begin($action, $method){
            echo "<form action='$action' method='$method'>";
            return new Form();
        }

        public static function end(){

            echo "
                    <button type='submit' class='btn btn-primary mt-2'>Submit</button>
                </form>
           ";
        }

        public function field($model, $attribute, $type = null){
            return new Field($model, $attribute, $type);
        }
    }