<?php  
//code a sanitized form in php?
if(isset($_POST['submit']) && !empty($_POST['submit'])){

    // use a boolean variable to keep track of errors
    $error = false;

    // Username validation
    $username = trim($_POST['username']);
    $username_pattern = "/^[a-zA-Z0-9]{3,15}$/"; // username should contain only letters and numbers, and length should be between 3 and 15 characters
    if(preg_match($username_pattern, $username)){
        // success
    }else{
        // error
        $error = true;
    }

    // Password validation
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    if(strlen($password) >= 6 && $password===$confirm_password){ // length of the password should be greater than or equal to 6
       // success
    }else{
       // error
       $error = true;
    }

    // First name validation
    $first_name = trim($_POST['first_name']);
    $first_name_pattern = "/^[a-zA-Z]{2,15}$/";
    if(preg_match($first_name_pattern, $first_name)){ // first name should contain only letters and length should be between 2 and 15 characters
        // success
    }else{
        // error
        $error = true;
    }


    // Last name validation
    $last_name = trim($_POST['last_name']);
    $last_name_pattern = "/^[a-zA-Z]{2,15}$/";
    if(preg_match($last_name_pattern, $last_name)){ // last name should contain only letters and length should be between 2 and 15 characters
        // success
    }else{
        // error
        $error = true;
    }

    // Email validation
    $email = trim($_POST['email']);
    $email_pattern = "/^([a-z0-9\._\+\-]{3,30})@([a-z0-9\-]{2,30})((\.([a-z]{2,20})){1,3})$/";
    if(preg_match($email_pattern, $email)){ // validate email addresses
        // success
    }else{
        // error
        $error = true;
    }

    if(!$error){
        // all fields are validated. Now do your database operations.
    
    }else{
        // display error message
    }
}
