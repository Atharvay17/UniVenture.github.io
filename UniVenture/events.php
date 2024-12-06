<?php 
include 'partials/header.php';

  //fetch posts from posts table
  $query = "SELECT * FROM posts ORDER BY date_time DESC";
  $posts = mysqli_query($connection,$query)
?>


    <!--------------------------------- Search Bar --------------------------------->

    <section class="search__bar">
        <form class="container search__bar-container" action="<?= ROOT_URL?>search.php" method="GET">
            <div>
                <i class="uil uil-search"></i>
                <input type="search" name="search" placeholder="Search">
            </div>
            <button type="submit" name="submit" class="form__btn"> Go </button>
        </form>
    </section>


    <!--------------------------------- End of Search Bar --------------------------------->


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



   <!------------------------------------------  Posts  ------------------------------------------>


   <section class="posts" id="posts">
        <h3 class="cat_title"> Events </h3>

        
          <?php  while($post = mysqli_fetch_assoc($posts)) : ?>
<div class="container posts__container">
            <article class="post">
                <div class="post__thumbnail">
                    <img src="./images/<?= $post['thumbnail']?>">
                </div>
                <div class="post__info">

                <?php 
                       //fetch category from categories table using category_id of post
                    $category_id = $post['category_id'];
                    $category_query = "SELECT * FROM categories WHERE id=$category_id";
                    $category_result = mysqli_query($connection, $category_query);
                    $category = mysqli_fetch_assoc($category_result);
                ?>

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
            <?php   endwhile ?>
            </div>
    </section>
           


    <!---------------------------------- End of Posts  ---------------------------------->




    <!---------------------------------- Categories  ---------------------------------->
    
    <!-- <section class="category__buttons">
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