<?php
require '../partials/header.php';

//check login sttus 
if(!isset($_SESSION['user-id'])) {
    header('location:' . ROOT_URL . 'signin.php');
    die();
}
