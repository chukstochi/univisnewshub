<?php
include 'partials/header.php';
// require_once 'config/database.php';
?>
<!-- search -->
<section class="search__bar">
     <form class="search__bar-container" action="">
          <div>
               <i class="bx bx-search bar"></i>
               <input type="search" name="" placeholder="search">
          </div>
          <button type="submit" class="btn">Go</button>
     </form>
</section>
<!-- search ends here -->


<section class="post">
     <div class="container">
          <h2 class="section__title">WORLD NEWS</h2>

          <div class="post__grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 2rem;">
               <?php
               // Get WORLD NEWS category ID
               $category_query = "SELECT id FROM categories WHERE title='WORLD NEWS' LIMIT 1";
               $category_result = mysqli_query($connection, $category_query);
               $world_category = mysqli_fetch_assoc($category_result);

               if ($world_category) {
                    $category_id = $world_category['id'];
                    $posts_query = "SELECT * FROM posts WHERE category_id=$category_id ORDER BY date_time DESC";
                    $posts_result = mysqli_query($connection, $posts_query);

                    while ($post = mysqli_fetch_assoc($posts_result)) {
                         // Fetch author
                         $author_id = $post['author_id'];
                         $author_query = "SELECT * FROM users WHERE id=$author_id";
                         $author_result = mysqli_query($connection, $author_query);
                         $author = mysqli_fetch_assoc($author_result);
               ?>
                         <article class="post__card" style="border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1); overflow: hidden;">
                              <div class="post__thumbnail">
                                   <img src="images/<?= $post['thumbnail'] ?>" alt="<?= $post['title'] ?>" style="width: 100%; height: 180px; object-fit: cover;">
                              </div>
                              <div class="post__info" style="padding: 1rem;">
                                   <a href="world-news.php" class="category__button">WORLD NEWS</a>
                                   <h3 class="post__title"><a href="post.php?id=<?= $post['id'] ?>"><?= $post['title'] ?></a></h3>
                                   <p><?= substr($post['body'], 0, 100) ?>...</p>

                                   <div class="post__author" style="display: flex; align-items: center; margin-top: 1rem;">
                                        <img src="images/<?= $author['avatar'] ?>" style="width: 40px; height: 40px; border-radius: 50%; margin-right: 10px;">
                                        <div>
                                             <h5>By: <?= "{$author['firstname']} {$author['lastname']}" ?></h5>
                                             <small><?= date("M d, Y - H:i", strtotime($post['date_time'])) ?></small>
                                        </div>
                                   </div>
                              </div>
                         </article>
               <?php
                    }
               } else {
                    echo "<p>No posts found in this category.</p>";
               }
               ?>
          </div>
     </div>
</section>

<?php include 'partials/footer.php'; ?>