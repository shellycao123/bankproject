<?php

function is_blank($value){
    return(!isset($value) || trim($value) =="");
}

function has_presence($value){
    return !is_blank($value);
}

function has_length_greater_than($value, $min){
    $length = strlen($value);

    return $length > $min;
}

function has_length_less_than($value, $max){
    $length = strlen($value);

    return $length < $max;
}

function has_exact_length($value, $l){
    $length = strlen($value);
    return $length == $l;
}

function has_length($value,$options){
   // echo has_length_greater_than($value, $options['min'] -1);
    if(isset($options['max'])&& has_length_greater_than($value, $options['max'] -1)){
        return false;
    }
    elseif(isset($options['min'])&& has_length_less_than($value, $options['min'] -1)){
        return false;
    }
    elseif(isset($options['exact'])&& !has_exact_length($value, $options['exact'] )){
        return false;
    }
    else{
        return true;
    }
}

function has_inclusion_of($value,$set){
    return in_array($value, $set);
}

function has_exclusion_of($value,$set){
    return !in_array($value, $set);
}

//strpos return false if it's not present, otherwise return the exact position
//use !== to prevent 0 from being considered as false
function has_string($value, $required_string){
    return strpos($value,$required_string)!==false;
}

function has_valid_email_format($value){
    $email_regex  = '/\A[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,}\Z/i';
    return preg_match($email_regex, $value) === 1;
}

function has_unique_page_menu_name($name){
    global $db;

    $result = find_all_pages([]);
    while($page = mysqli_fetch_assoc($result)){
        if($page['menu_name'] === $name){
            return false;
        }
    }
    return true;
}