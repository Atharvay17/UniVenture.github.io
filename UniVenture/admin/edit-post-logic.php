<?php 
require 'config/database.php';

//make sure edit post button was clicked
if(isset($_POST['submit'])) {
    $id = filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);
    $previous_thumbnail_name = filter_var($_POST['previous_thumbnail_name'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $title = filter_var($_POST['title'], FILTER_SANITIZE_SPECIAL_CHARS);
    $body = filter_var($_POST['body'], FILTER_SANITIZE_SPECIAL_CHARS);
    $category_id = filter_var($_POST['category'] , FILTER_SANITIZE_NUMBER_INT);
    $thumbnail = $_FILES['thumbnail'];

    //set is_featured to 0 if it was unchecked

    //check and validate input values
    if(!$title) {
        $_SESSION['edit-post'] = "Couldn't update post. Invalid title on edit page. ";
    } elseif(!$category_id) {
        $_SESSION['edit-post'] = "Couldn't update post. Invalid category on edit page. ";
    } elseif(!$body) {
        $_SESSION['edit-post'] = "Couldn't update post. Invalid body on edit page. ";
    }  else {
        //delet existing thumbnail if new thumbnail is added
        if($thumbnail['name']) {
            $previous_thumbnail_path = '../images/' . $previous_thumbnail_name;
            if ($previous_thumbnail_path) {
                unlink($previous_thumbnail_path);
            }

            //work on new thumbnail 
            //rename image

            $time = time();
            $thumbnail_name = $time . $thumbnail['name'];
            $thumbnail_tmp_name = $thumbnail['tmp_name'];
            $thumbnail_destination_path = '../images/' . $thumbnail_name;

            //make sure file is an image
            $allowed_files = ['png', 'jpg', 'jpeg'];
            $extension = explode('.' , $thumbnail_name);
            $extension = end($extension);
            if (in_array($extension, $allowed_files)){
                //make sure avatar is not too large
                if($thumbnail['size'] < 2_000_000) {
                    //upload avatar
                    move_uploaded_file($thumbnail_tmp_name, $thumbnail_destination_path);
                } else {
                    $_SESSION['edit-post'] = "Couldn't update post. Thumbnail size too big. Should be less than 2MB";
                }
            } else {
                $_SESSION['edit-post'] = "Couldn't update post. Thumbnail should be png, jpg or jpeg";
            }
        }
    }

    if($_SESSION['edit-post']) {
        //redirect to manage from page if form was invalid
        
        header('location:' . ROOT_URL . 'admin/');
        // echo 'hey';
        die();
    } else {
        //set is_featured of all posts to 0 if is_featured for this post is 1
    
        //set thumbnail name if a new one was uploaded, else keep old thumbnail name
        $thumbnail_to_insert = $thumbnail_name ?? $previous_thumbnail_name;

        $query = "UPDATE posts SET title = '$title', body = '$body', thumbnail = '$thumbnail_to_insert', category_id=$category_id WHERE id=$id LIMIT 1";
        $result = mysqli_query($connection, $query);
        
       }
    if(!mysqli_errno($connection)) {
        $_SESSION['edit-post-success'] = "Post updated successfully";
    }
}
header('location: ' . ROOT_URL . 'admin/index.php');
die();