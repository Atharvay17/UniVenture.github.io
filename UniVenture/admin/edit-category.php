<?php
include 'partials/header.php';

if(isset($_GET['id'])) {
   $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

   //fetch from db
   $query = "SELECT * FROM categories WHERE id=$id";
   $result = mysqli_query($connection, $query);
   if(mysqli_num_rows($result) == 1){
    //fill the form
    $category = mysqli_fetch_assoc($result);
   }
} else {
    header('location: ' . ROOT_URL . 'admin/manage-categories');
    die();
}
?>
    
<section class="form__section">

<div class="container__formsection-container">

    <h2>Edit Category</h2>

    <!-- <div class="alert__message error">
        <p> this is a error message </p>
    </div> -->

        <form action="<?= ROOT_URL?>admin/edit-category-logic.php" method="POST">
            <input type="hidden" name="id" value="<?= $category['id'] ?>">
            <input type="text" name="title" value="<?= $category['title'] ?>" placeholder="Title">
            <textarea rows="4" name="description" placeholder="Description"> <?= $category['description'] ?></textarea>

            <button type="submit" name="submit" class="form__btn">Update Category</button>

            

        </form>
    </div>
</section>


<?php
include '../partials/footer.php';
?>