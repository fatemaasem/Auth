<?php 
    function response_code($code,$mes){
        if(is_array($mes))
           print_r( json_encode(( $mes)));
        else
            echo "$mes";
        http_response_code($code);
    }
    function validateString($str,$value="value"){
        $errors=[];
        $str=htmlspecialchars(trim($str));
        if(empty($str)){
            $errors[]="the $value must be not empty.";
        }
        if(is_numeric($str)){
            $errors[]="the $value must have characters .";
        }
        if(!empty($errors))
        return $errors;
        return $str;
       }
       function validateEmail($email) {
        // Remove leading and trailing whitespaces
        $email = htmlspecialchars(trim($email));
        // Check if the email is a valid format using a regular expression
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return $email;
        } else {
            return  ['Email Not valid'];
        }
    }
?>