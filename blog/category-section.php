<?php
require './partials/header.php';
// require_once 'config/database.php';

function render_category_section($category_title, $section_id)
{
     global $connection;

     // Get the category ID
     $category_query = "SELECT * FROM categories WHERE title='$category_title' LIMIT 1";
     $category_result = mysqli_query($connection, $category_query);
     $category = mysqli_fetch_assoc($category_result);
     if (!$category) return;

     $category_id = $category['id'];

     // Get the latest post for the category
     $latest_query = "SELECT * FROM posts WHERE category_id=$category_id ORDER BY date_time DESC LIMIT 1";
     $latest_result = mysqli_query($connection, $latest_query);
     $latest_post = mysqli_fetch_assoc($latest_result);

     // Get older posts excluding the latest
     $older_query = "SELECT * FROM posts WHERE category_id=$category_id ORDER BY date_time DESC LIMIT 1, 10";
     $older_result = mysqli_query($connection, $older_query);
?>

     <section class="opinion-section" id="<?= $section_id ?>">
          <h2 class="opinion-header"><?= strtoupper($category_title) ?></h2>

          <!-- Featured Post -->
          <?php if ($latest_post): ?>
               <div class="container featured__container">
                    <div class="post__thumbnail clean-thum">
                         <img src="images/<?= $latest_post['thumbnail'] ?>" alt="Post Image">
                    </div>
                    <div class="post__info">
                         <a href="category-posts.php?id=<?= $category_id ?>" class="category__button"><?= strtoupper($category_title) ?></a>
                         <h2 class="post__title">
                              <a href="post.php?id=<?= $latest_post['id'] ?>"><?= $latest_post['title'] ?></a>
                         </h2>
                         <p class="post__body"><?= substr($latest_post['body'], 0, 200) ?>...</p>
                         <div class="post__author">
                              <div class="post__author-avatar">
                                   <img src="images/<?= $latest_post['author_avatar'] ?? 'default.png' ?>" alt="Author">
                              </div>
                              <div class="post__author-info">
                                   <h5>By: <?= $latest_post['author'] ?? 'Admin' ?></h5>
                                   <small><?= date('M d, Y - H:i', strtotime($latest_post['date_time'])) ?></small>
                              </div>
                         </div>
                    </div>
               </div>
          <?php endif; ?>

          <!-- Older Posts -->
          <?php while ($post = mysqli_fetch_assoc($older_result)): ?>
               <article class="opinion-article">
                    <img src="images/<?= $post['thumbnail'] ?>" alt="Post Image">
                    <div class="content">
                         <a href="post.php?id=<?= $post['id'] ?>">
                              <h3><?= strtoupper($post['author'] ?? 'Contributor') ?></h3>
                         </a>
                         <p><?= substr($post['body'], 0, 160) ?>...</p>
                    </div>
               </article>
          <?php endwhile; ?>

          <a href="category-posts.php?id=<?= $category_id ?>" class="see-all">SEE ALL</a>
     </section>

<?php } // end function 
?>