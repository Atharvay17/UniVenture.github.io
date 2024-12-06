<?php
include 'partials/header.php';

if(isset($_GET['id'])) {
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
    $query = "SELECT * FROM users WHERE id=$id";
    $result = mysqli_query($connection, $query);
    $user = mysqli_fetch_assoc($result);
} else {
    header('location: ' . ROOT_URL . 'admin/manage-users.php');
    die();
}
?>
    
<section class="form__section">

<div class="container__formsection-container">

    <h2>Edit User</h2>

    

    <form action="<?= ROOT_URL ?>admin/edit-user-logic.php" enctype="multipart/form-data" method="POST">
        <input type="text" value="<?= $user['firstname'] ?>" name="firstname" placeholder="First Name">
        <input type="text" value="<?= $user['lastname'] ?>" name="lastname" placeholder="Last Name">
        <!-- <input type="text" placeholder="Username">
        <input type="text" placeholder="Email">
        <input type="text" placeholder="Create Password">
         <input type="text" placeholder="Confirm Password"> -->
        <input type="text" name="firstname" placeholder="First Name">
        <input type="text" name="lastname" placeholder="Last Name">
        <select name="userrole"> 
            <option value="0">Student</option>
            <option value="1">Admin</option>
        </select>
        <button type="submit" name="submit" class="form__btn">Add User</button>

        <!-- <small> Already have an account? <a href="signin.html"> Sign in.</a></small> -->

    </form>
    </div>
</section>


<?php
include '../partials/footer.php';
?>