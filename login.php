<?php
require_once "inc/connection.php";
require_once "inc/function.php";

if($_SERVER['REQUEST_METHOD']=='POST'){
    $email=$_POST['email'];
    $password=$_POST['password'];
    //validation
    $emailValidation=validateEmail($email);
    $passwordValidation=validateString($password,'password');
    //echo $passwordValidation;
    $errors=[];
    if(is_array($emailValidation)){//return message if name is not valid
        $errors=array_merge($errors, $emailValidation);
    }
    if(is_array($passwordValidation)){//return message if name is not valid
        $errors=array_merge($errors,$passwordValidation);
    }
    if( empty($errors)){//then there is not error found
        //check if user is found using email (email unique)
        $query="select * from users where 	user_email='$email'";
        $runQuery=mysqli_query($conn,$query);
        if(mysqli_num_rows($runQuery)==1){
            //login
            $user=mysqli_fetch_assoc($runQuery);
            //check if password is correct for this user
            $checkPassword=password_verify($passwordValidation,$user['user_password']);
            if($checkPassword){
                response_code(200,'login successfully');
            }
            else{
                response_code(404,'Password not found');
            }
        }
        else{
            response_code(404,'User not found');
        }
    }
    else{
        response_code(404,$errors);
    }
}
else{
    response_code(503,'There is an error on request');
}