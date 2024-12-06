<?php
 require 'config/database.php';


// get signup form data if signup button was clicked
if (isset($_POST['submit'])) {
    $firstname = filter_var($_POST['firstname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $lastname = filter_var($_POST['lastname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $username = filter_var($_POST['username'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $createpassword = filter_var($_POST['createpassword'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $confirmpassword = filter_var($_POST['confirmpassword'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $is_admin = filter_var($_POST['userrole'], FILTER_SANITIZE_NUMBER_INT);
    $avatar = $_FILES['avatar'];
    // var_dump($avatar);

    // validate ip values
    if(!$firstname) {
        $_SESSION['add-user'] = "Please enter your First Name";
    } elseif(!$lastname) {
        $_SESSION['add-user'] = "Please enter your Last Name";
    } elseif(!$username) {
        $_SESSION['add-user'] = "Please enter your Username";
    } elseif(!$email) {
        $_SESSION['add-user'] = "Please enter a valid email";
    // } elseif(!$is_admin) {
    //     $_SESSION['add-user'] = "Please select user role";
    // }elseif(strlen($createpassword) < 8 || strlen($confirmpassword) < 8) {
        // $_SESSION['add-user'] = "Password should be 8+ charachters";
    } elseif(!$avatar['name']) {
        $_SESSION['add-user'] = 'Please add avatar';
    } else{
        //check if passwords dont match
        if($createpassword !== $confirmpassword){
            $_SESSION['add-user'] = "Passwords do not match";
        } else{
            //hash password
            $hashed_password = password_hash($createpassword, PASSWORD_DEFAULT);
           
            //check if username and email already exist in db
            $user_check_query =  "SELECT * FROM users WHERE username = '$username' OR email = '$email' ";
            $user_check_result = mysqli_query($connection, $user_check_query);
            if(mysqli_num_rows($user_check_result) > 0) {
                $_SESSION['signup'] = "Username or Email already exists";
            }
            else{
                //work on avatar
                //rename avatar file

                $time = time(); //current time as a Unix timestamp
                $avatar_name = $time . $avatar['name'];
                $avatar_tmp_name = $avatar['tmp_name'];
                $avatar_destination_path = '../images/' . $avatar_name;

                //make sure file is an image
                $allowed_files = ['png', 'jpg', 'jpeg'];
                $extention = explode('.', $avatar_name);
                $extention = end($extention);
                if(in_array($extention, $allowed_files)){
                    //make sure image is not too large (1mb)
                    if($avatar['size']< 1000000) {
                        // upload avatar
                        move_uploaded_file($avatar_tmp_name, $avatar_destination_path);
                    } else{
                        $_SESSION['add-user'] = 'File size too big. Should be less than 1MB';
                    }
                }
                else{
                    $_SESSION['add-user'] = "File should be png, jpg or jpeg";
                }
            }
        }
    }

    //redirect back to sign up page, if error
    if(isset($_SESSION['add-user'])){
        //pass form data back to sign up page

        $_SESSION['add-user-data'] = $_POST;
        header('location:' . ROOT_URL . '/admin/add-user.php');
        die();
    } else{
        //insert new user into users table
        $insert_user_query = "INSERT INTO users SET firstname='$firstname', lastname='$lastname', username='$username', email='$email', password='$hashed_password', avatar='$avatar_name', is_admin=$is_admin";
        $insert_user_result = mysqli_query($connection, $insert_user_query);

        if(!mysqli_errno($connection)) {
            //redirect to login page with success msg
            $_SESSION['add-user-success'] = "New user $firstname $lastname added successfully";
            header('location:' . ROOT_URL . 'admin/manage-users.php');
            die();
        }
    }
}
else {
    //if buytton wasnt clicked then bounce back to signup page
    header('location: ' . ROOT_URL . 'admin/add-user.php');
    die();
}