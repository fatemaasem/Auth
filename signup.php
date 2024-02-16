<?php
require_once "inc/connection.php";
require_once "inc/function.php";

if($_SERVER['REQUEST_METHOD']=='POST'){
    $name=$_POST['name'];
    $email=$_POST['email'];
    $password=$_POST['password'];
    //validation
    $nameValidation=validateString($name,'name');
    $emailValidation=validateEmail($email);
    $passwordValidation=validateString($password,'password');
    $errors=[];
    $errorNotFound=1;
    if(is_array($nameValidation)){//return message if name is not valid
        $errors=array_merge($errors,$nameValidation);
    }
    if(is_array($passwordValidation)){//return message if name is not valid
        $errors=array_merge($errors,$passwordValidation);
    }
    if(is_array($emailValidation)){//return message if name is not valid
        $errors=array_merge($errors, $emailValidation);
    }
    if( empty($errors)){//then there is not error found
        //check if user is found using email (email unique)
        $query="select * from users where 	user_email='$email'";
        $runQuery=mysqli_query($conn,$query);
        if(mysqli_num_rows($runQuery)==0){
            //insert
            $hashedPassword=password_hash($password,PASSWORD_DEFAULT);
            $query="insert into users (`user_name`,`user_email`,`user_password`) values('$nameValidation','$emailValidation','$hashedPassword')";
            $runQuery=mysqli_query($conn,$query);
            if($runQuery){
                response_code(200,'insert successfully');
            }
            else{
                response_code(404,'There is an error on insert');
            }
        }
        else{
            response_code(404,'User is found already');
        }
    }
    else{
        response_code(404,$errors);
    }
}
else{
    response_code(503,'There is an error on request');
}