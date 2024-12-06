 <?php 
  include'partials/header.php';

  //fetch featured post from db

  //fetch posts from posts table (only 9)
  $query = "SELECT * FROM posts ORDER BY date_time DESC LIMIT 9";
  $posts = mysqli_query($connection,$query)

 ?>

    <!---------------------------------- top branding ---------------------------------->
    <section class="home" id="home" >
        <div class="content">
            Your Passport to Campus Adventures!
            <!-- <a href="events.php" class="button">Browse</a> -->
            <!-- <div class="logo">
                <img src="systemimages/Untitled1_20231019085738.png">
            </div> -->
          
        </div>
        <div class="rectangle">
            <p class="rectangle_text">Campus Events. <br> Unified & <br> Simplified. <br> </p>   
        </div>
        <div class="browse">
        <a href="#Categories" class="browse__button"> Browse </a>
    </div>
        <!-- <div class="wave">
            <svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
                <path d="M985.66,92.83C906.67,72,823.78,31,743.84,14.19c-82.26-17.34-168.06-16.33-250.45.39-57.84,11.73-114,31.07-172,41.86A600.21,600.21,0,0,1,0,27.35V120H1200V95.8C1132.19,118.92,1055.71,111.31,985.66,92.83Z" class="shape-fill"></path>
            </svg>
        </div> -->
    </section>


    <!---------------------------------- end of top branding ---------------------------------->


    <!---------------------------------- Welcome to Univenture ---------------------------------->


    <header>
        <!-- <section> -->
        <div class="container header__container">
            <div class="header__left">
                <h1> <pre>

                </pre>
                    Welcome to UniVenture!</h1>
                <p>The primary goal of UniVenture is to provide students, faculty, and staff with a centralized source of information to help them stay informed about and participate in campus activities.
                    <!--  Univenture is a centralized source of information about campus activities, to help students, faculty and staff stay informed and participate. -->
                </p>
                <!-- <a href="events.php" class="btn btn-primary">Get Started</a> -->
            </div>
           
            <div class="header__right">
                <div class="header__right-image">

                    <img class="welcome_img" src="systemimages/welcome2.png">
                </div>
            </div>
        </div>
        <!-- <div class="wave2">
            <svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
                <path d="M985.66,92.83C906.67,72,823.78,31,743.84,14.19c-82.26-17.34-168.06-16.33-250.45.39-57.84,11.73-114,31.07-172,41.86A600.21,600.21,0,0,1,0,27.35V120H1200V95.8C1132.19,118.92,1055.71,111.31,985.66,92.83Z" class="shape-fill"></path>
            </svg>
        </div>
       </section> -->
    </header>
    

   <!---------------------------------- end of Welcome to Univenture ---------------------------------->



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
            <a href=""class="category__button">Competitions</a> 
            <a href=""class="category__button">Quiz</a>
            <a href=""class="category__button">Educational Program</a> 
            <a href=""class="category__button">Recruitment</a>
            <a href=""class="category__button"> Internships include a warning </a>  
        </div>
    </section> -->

   <!---------------------------------- End of Categories  ---------------------------------->



<?php 
 include'partials/footer.php';
?>