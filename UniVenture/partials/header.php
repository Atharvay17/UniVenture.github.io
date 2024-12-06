<?php
require 'config/database.php';

//fetch current user from database
if(isset($_SESSION['user-id'])) {
    $id = filter_var($_SESSION['user-id'], FILTER_SANITIZE_NUMBER_INT);
    $query = "SELECT avatar FROM users WHERE id =$id";
    $result = mysqli_query($connection, $query);
    $avatar = mysqli_fetch_assoc($result);
}
?>


<!DOCTYPE php>
<php lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UniVenture</title>
    <link rel="stylesheet" href="<?= ROOT_URL ?>css/styles.css">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/line.css">
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Shrikhand&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Text&family=Josefin+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">
</head>


<body>

    <!---------------------------------- nav bar ---------------------------------->
    <nav>
        <div class="container nav__container">
            <a href="<?= ROOT_URL ?>index (1).php" class="nav__logo">UniVenture</a>
            <ul class="nav__items">
                <li><a href="<?= ROOT_URL ?>index (1).php">&nbsp;&nbsp;&nbsp;Home</a></li>
                <li><a href="<?= ROOT_URL ?>about.php">About</a></li>
                <li><a href=" <?= ROOT_URL ?>events.php">Events</a></li>
                <li><a href="<?= ROOT_URL ?>contact.php">Contact</a></li>
                <?php if(isset($_SESSION['user-id'])): ?>
                    <li class="nav__profile">
                    <div class="avatar">
                        <img class="avatar_img" src="<?= ROOT_URL. 'images/'.$avatar['avatar'] ?>" >
                    </div>
                    <ul>
                    <?php if(isset($_SESSION['user_is_admin'])): ?>
                        <li><a href="<?= ROOT_URL ?>admin/index.php">Dashboard</a></li>
                        <?php endif ?>
                        <li><a href="<?= ROOT_URL ?>logout.php">Logout</a></li>
                    </ul>
                </li>
                <?php else : ?>
                <li><a href="<?= ROOT_URL ?>signin.php">Signin</a></li>
                <?php endif ?>
            </ul>
            </ul>
            
            
            <button id="open__nav-btn"><i class="uil uil-bars"></i></button>
            <button id="close__nav-btn"><i class="uil uil-multiply"></i></button>
        </div>
    </nav>
    <!---------------------------------- end of nav bar ---------------------------------->