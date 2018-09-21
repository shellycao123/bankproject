<?php
    function url_for($script_path){
        //add the / if forget
        if($script_path[0] != '/'){
            $script_path = '/' . $script_path;
        }
        return WWW_ROOT . $script_path;
    }

    function u($query){
        return urlencode($query);
    }

    function raw_u($path){
        return rawurlencode($path);
    }

    function h($dynamic){
        return htmlspecialchars($dynamic);
    }

    function error_404(){
        header($_SERVER['SERVER_PROTOCOL'] . "404 Not Found");
        exit;
    }

    function error_500(){
        header($_SERVER['SERVER_PROTOCOL'] . "500 Internal Server Error");
    }

    function redirect_to($location){
        header("Location: " . $location);
    }

    function is_get_request()
    {
        return $_SERVER['REQUEST_METHOD'] == 'GET';
    }

    function is_post_request()
    {
        return $_SERVER['REQUEST_METHOD'] == 'POST';
    }

    function display_errors($errors){
        $output = '';
        if(!empty($errors)){
            $output .= '<div class = \'errors\'>';
            $output .= "Please fix the following items:";
            $output .= '<ul>';
            foreach($errors as $error){
                $output .= '<li>' . h($error) . '</li>';
            }
            $output .= '</ul></div>';
        }
        return $output;
    }

