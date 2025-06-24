<?php
require 'partials/header.php';
require 'config/database.php';

// Search term
$search = isset($_GET['search']) ? mysqli_real_escape_string($connection, $_GET['search']) : '';
$current_page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int) $_GET['page'] : 1;
$posts_per_page = 10;
$offset = ($current_page - 1) * $posts_per_page;

// Count total matching posts
$total_query = "SELECT COUNT(*) as total FROM posts WHERE title LIKE '%$search%' OR body LIKE '%$search%'";
$total_result = mysqli_query($connection, $total_query);
$total_posts = mysqli_fetch_assoc($total_result)['total'];
$total_pages = ceil($total_posts / $posts_per_page);

// Get paginated posts
$query = "SELECT * FROM posts 
          WHERE title LIKE '%$search%' OR body LIKE '%$search%' 
          ORDER BY date_time DESC 
          LIMIT $posts_per_page OFFSET $offset";
$result = mysqli_query($connection, $query);
?>

<section class="posts">
     <div class="container posts__container">
          <h2>Search Results for "<?= htmlspecialchars($search) ?>"</h2>

          <?php if (mysqli_num_rows($result) > 0) : ?>
               <?php while ($post = mysqli_fetch_assoc($result)) : ?>
                    <article class="post">
                         <div class="post__thumbnail">
                              <img src="images/<?= $post['thumbnail'] ?>" alt="Post Thumbnail">
                         </div>
                         <div class="post__info">
                              <h3 class="post__title">
                                   <a href="<?= ROOT_URL ?>post.php?id=<?= $post['id'] ?>"><?= $post['title'] ?></a>
                              </h3>
                              <p class="post__body">
                                   <?= substr($post['body'], 0, 150) ?>...
                              </p>
                         </div>
                    </article>
               <?php endwhile; ?>
          <?php else : ?>
               <p>No results found for "<?= htmlspecialchars($search) ?>"</p>
          <?php endif; ?>

          <!-- Pagination -->
          <?php if ($total_pages > 1) : ?>
               <div class="pagination">
                    <?php if ($current_page > 1) : ?>
                         <a href="?search=<?= urlencode($search) ?>&page=<?= $current_page - 1 ?>" class="btn">Prev</a>
                    <?php endif; ?>

                    <?php for ($i = 1; $i <= $total_pages; $i++) : ?>
                         <a href="?search=<?= urlencode($search) ?>&page=<?= $i ?>" class="btn <?= $i === $current_page ? 'btn-primary' : '' ?>">
                              <?= $i ?>
                         </a>
                    <?php endfor; ?>

                    <?php if ($current_page < $total_pages) : ?>
                         <a href="?search=<?= urlencode($search) ?>&page=<?= $current_page + 1 ?>" class="btn">Next</a>
                    <?php endif; ?>
               </div>
          <?php endif; ?>
     </div>
</section>

<?php require 'partials/footer.php'; ?>