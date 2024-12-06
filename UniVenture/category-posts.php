<?php 
include 'partials/header.php';
error_reporting(E_ERROR | E_PARSE);
//fetch posts of id is set
if(isset($_GET['id'])) {
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
    $query = "SELECT * FROM posts WHERE category_id = $id ORDER BY date_time DESC";
    $posts = mysqli_query($connection,$query);
} else {
    header('location: ' . ROOT_URL . 'blog.php');
    die();
}
?>


     
 <header class="category__title">
    <h2>   
         <?php 
                       //fetch category from categories table using category_id of post
                    $category_id = $id;
                    $category_query = "SELECT * FROM categories WHERE id=$id";
                    $category_result = mysqli_query($connection, $category_query);
                    $category = mysqli_fetch_assoc($category_result);

                    echo $category['title']
                ?>
    </h2>
 </header>
 
 
    <!------------------------------------------  Posts  ------------------------------------------>
<?php if (mysqli_num_rows($posts) > 0) : ?>

    <section class="posts" id="posts">
        <h3 class="cat_title"> Events </h3>
        <div class="container posts__container">
          <?php  while ($post = mysqli_fetch_assoc($posts)) : ?>
            <article class="post">
                <div class="post__thumbnail">
                    <img src="./images/<?= $post['thumbnail']?>">
                </div>
                <div class="post__info">

                    <a href="<?= ROOT_URL ?>category-posts.php?id=<?= $post['category_id'] ?>" class="category__button"> <?= $category['title'] ?> </a>
                    <h3 class="post__title">
                        <a href="<?= ROOT_URL ?>post.php?id=<?= $post['id'] ?>"><?= $post['title'] ?>
                    </a></h3>
                    <p class="post__body">
                    <?= substr($post['body'], 0, 150)?>...
                    </p>
                    <!-- <div class="post__author-info"> -->
                        <!-- <h5>By: Kanye West</h5> -->
                        
                        <small>
                        <?= date("M d, Y - H:i", strtotime($post['date_time'])) ?>    
                    </small>
                    </div>
                </div>
            </article> 
            <?php endwhile ?>
            </div>
    </section>
    <?php else : ?>
          <div class="alert__message error lg">
            <p>No posts found for this category</p>
          </div>
        
        <?php endif ?>


    <!---------------------------------- End of Posts  ---------------------------------->



         <!---------------------------------- Categories  ---------------------------------->
    
         <section class="category__buttons" id="Categories">
    <h3 class="cat_title"> Categories</h3>
    <div class="container category__buttons-container">
        
          <?php  
             $all_categories_query = "SELECT * FROM categories";
             $all_categories = mysqli_query($connection,$all_categories_query);
          ?>
         <?php while($category = mysqli_fetch_assoc($all_categories)) :  ?>

        <a href="<?= ROOT_URL ?>category-posts.php?id=<?= $category['id'] ?>"class="category__button"><?= $category['title'] ?></a>

        <?php endwhile ?>

     <!-- include a warning for internships--> 
    </div>
</section>

<!---------------------------------- End of Categories  ---------------------------------->




    <!---------------------------------- Categories  ---------------------------------->
<!--     
    <section class="category__buttons">
        <div class="container category__buttons-container">
            <a href=""class="category__button">Alegria</a>
            <a href=""class="category__button">Tech Alegria</a>
            <a href=""class="category__button">Competitions</a> -->
            <!-- <a href=""class="category__button">Quiz</a> -->
            <!-- <a href=""class="category__button">Educational Program</a>
            <a href=""class="category__button">Recruitment</a>
            <a href=""class="category__button"> Internships include a warning </a>  -->
        <!-- </div>
    </section> -->

   <!---------------------------------- End of Categories  ---------------------------------->



 

   <?php 
include'partials/footer.php';
?>