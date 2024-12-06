<?php
require 'config/database.php';

//if signin button was pressed 

if (isset($_POST['submit'])) {
  //get form data
  $username_email = filter_var($_POST['username_email'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $password = filter_var($_POST['password'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

  if(!$username_email){
    $_SESSION['signin'] = "Enter Username or Email";
  } elseif(!$password) {
    $_SESSION['signin'] = "Enter Password";
  } else {
    // proceed and fetch user from db
    $fetch_user_query = "SELECT * FROM users WHERE username='$username_email' OR email='$username_email'";
    $fetch_user_result = mysqli_query($connection, $fetch_user_query);
    
    if(mysqli_num_rows($fetch_user_result) == 1) {
        //convert the record into assoc array
        $user_record = mysqli_fetch_assoc($fetch_user_result);
        $db_password = $user_record['password'];
        //compare form password with db password
        if(password_verify($password, $db_password)) {
            //set session for acccess control 
            $_SESSION['user-id'] = $user_record['id'];
            // set session if user admin
            if($user_record['is_admin'] == 1){
                $_SESSION['user_is_admin'] = true;
            }

            //log user in
            header('location:' . ROOT_URL . 'index (1).php');
        } else {
            $_SESSION['signin'] = "Please check your input";
        }
    } else {
        $_SESSION['signin'] = "User not found";
    }
  }

  //if anhy problems, redirect back to signin page with login details
  if(isset($_SESSION['signin'])){
    $_SESSION['signin-data'] = $_POST;
    header('location:' . ROOT_URL . 'signin.php');
    die();
  }
  
} else{ //else go back to signin
    header('location:' . ROOT_URL . 'signin.php');
    die();
}