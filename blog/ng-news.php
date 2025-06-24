<?php
include 'partials/header.php';
require_once 'config/database.php';
?>

<!-- Search -->
<section class="search__bar">
     <form class="search__bar-container" action="">
          <div>
               <i class="bx bx-search bar"></i>
               <input type="search" name="" placeholder="Search">
          </div>
          <button type="submit" class="btn">Go</button>
     </form>
</section>
<!-- Search ends -->

<!-- NG News Posts Section -->
<section class="post">
     <div class="container">
          <h2 class="section__title">NG NEWS</h2>

          <div class="post__grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 2rem;">
               <?php
               // Get NG NEWS category ID
               $category_query = "SELECT id FROM categories WHERE title='NG NEWS' LIMIT 1";
               $category_result = mysqli_query($connection, $category_query);
               $ng_category = mysqli_fetch_assoc($category_result);

               if ($ng_category) {
                    $category_id = $ng_category['id'];

                    // JOIN posts with users for NG NEWS
                    $posts_query = "
                         SELECT 
                              posts.*, 
                              users.firstname, 
                              users.lastname, 
                              users.avatar 
                         FROM posts 
                         JOIN users ON posts.author_id = users.id 
                         WHERE posts.category_id = $category_id 
                         ORDER BY posts.date_time DESC
                    ";
                    $posts_result = mysqli_query($connection, $posts_query);

                    if (mysqli_num_rows($posts_result) > 0) {
                         while ($post = mysqli_fetch_assoc($posts_result)) {
               ?>
                              <article class="post__card" style="border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1); overflow: hidden;">
                                   <div class="post__thumbnail">
                                        <img src="images/<?= htmlspecialchars($post['thumbnail']) ?>" alt="<?= htmlspecialchars($post['title']) ?>" style="width: 100%; height: 180px; object-fit: cover;">
                                   </div>
                                   <div class="post__info" style="padding: 1rem;">
                                        <a href="ng-news.php" class="category__button">NG NEWS</a>
                                        <h3 class="post__title">
                                             <a href="post.php?id=<?= $post['id'] ?>">
                                                  <?= htmlspecialchars($post['title']) ?>
                                             </a>
                                        </h3>
                                        <p><?= htmlspecialchars(substr($post['body'], 0, 100)) ?>...</p>

                                        <div class="post__author" style="display: flex; align-items: center; margin-top: 1rem;">
                                             <img src="images/<?= htmlspecialchars($post['avatar']) ?>" alt="Author" style="width: 40px; height: 40px; border-radius: 50%; margin-right: 10px;">
                                             <div>
                                                  <h5>By: <?= htmlspecialchars($post['firstname'] . ' ' . $post['lastname']) ?></h5>
                                                  <small><?= date("M d, Y - H:i", strtotime($post['date_time'])) ?></small>
                                             </div>
                                        </div>
                                   </div>
                              </article>
               <?php
                         }
                    } else {
                         echo "<p>No NG NEWS posts found.</p>";
                    }
               } else {
                    echo "<p>NG NEWS category not found.</p>";
               }
               ?>
          </div>
     </div>
</section>

<?php include 'partials/footer.php'; ?>