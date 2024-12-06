<?php 
require 'config/database.php';

if(isset($_POST['submit'])) {
    $author_id = $_SESSION['user-id'];
    $title = filter_var($_POST['title'], FILTER_SANITIZE_SPECIAL_CHARS);
    $body = filter_var($_POST['body'], FILTER_SANITIZE_SPECIAL_CHARS);
    $category_id = filter_var($_POST['category'], FILTER_SANITIZE_NUMBER_INT);
    $thumbnail = $_FILES['thumbnail'];
    // $is_featured = filter_var($_POST['is_featured'], FILTER_SANITIZE_NUMBER_INT);

    //set is featured to 0 if uncheked
    // $is_featured = $is_featured == 1?: 0;
    if(!$title) {
        $_SESSION['add-post'] = "Enter post title";
    } elseif (!$category_id) {
        $_SESSION['add-post'] = "Select post category";
    } elseif(!$body) {
        $_SESSION['add-post'] = "Enter post body" ;
    } elseif (!$thumbnail['name']) {
        $_SESSION['add-post'] = "Choose post thumbnail" ;

    } else{ 
        //work on thumbnail
        //rename the image
        $time = time();
        $thumbnail_name = $time . $thumbnail['name'];
        $thumbnail_tmp_name = $thumbnail['tmp_name'];
        $thumbnail_destination_path = '../images/' . $thumbnail_name;

        //make sure file is an image
        $allowed_files = ['png', 'jpg', 'jpeg'];
        $extension = explode('.', $thumbnail_name);
        $extension = end($extension);
        if(in_array($extension, $allowed_files)) {
            //make sure img is not too large (2MB max)
            if($thumbnail['size'] < 2_000_000){
               //upload thumbnaik
               move_uploaded_file($thumbnail_tmp_name, $thumbnail_destination_path);
            } else {
                $_SESSION['add-post'] = "File size is too big. Should be less than 2MB";

            }
         }    else{
                $_SESSION['add-post'] = "file should be in png, jpg or jpeg format";

            }
    }
    // redirect back (with form data) to add-post if there is any problem
    if(isset($_SESSION['add-post'])) {
        $_SESSION['add-post-data'] = $_POST;
        header('location:' . ROOT_URL . 'admin/add-post.php');
        die();

    } else{
        //insert post into database
        $query = "INSERT INTO posts (title,body,thumbnail,category_id, author_id) VALUES ('$title', '$body', '$thumbnail_name', $category_id, $author_id) ";
        $result = mysqli_query($connection, $query);

        if(!mysqli_errno($connection)){
            $_SESSION['add-post-success'] = "New post added succesfully";
            header('location: ' . ROOT_URL . 'admin/index.php');
            die();
        }
    }

}

header('location: ' . ROOT_URL . 'admin/index.php');
die();