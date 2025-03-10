<?php

    use app\core\Application;


    function dd($data){
        echo "<pre>";
        var_dump($data);
        echo "</pre>";
        die();
    }

    function sanitize($data){
        return htmlentities($data, ENT_QUOTES, 'UTF-8');
    }

    function redirect($url){
        header("Location: $url");
        exit();
    }


    function asset($path){
        return $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . '/public/' . $path;
    }

    function view($view, $params = []){
        foreach($params as $key => $value){
            $$key = $value;
        }
        ob_start();
        include_once Application::$ROOT_DIR . "/views/$view.php";
        return ob_get_clean();
    }

    function user (){
        return Application::$app->user;
    }

    function isGuest(){
        return !user();
    }

    function sessionSet($key, $value){
        Application::$app->session->set($key, $value);
    }

    function sessionGet($key){
        return Application::$app->session->get($key);
    }
    
    function sessionRemove($key){
        Application::$app->session->remove($key);
    }
    
    function sessionFlashGet($key){
        return Application::$app->session->getFlash($key);
    }

    function sessionFlashSet($key, $message){
        Application::$app->session->setFlash($key, $message);
    }

