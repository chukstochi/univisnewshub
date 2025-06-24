<?php
require "partials/header.php";
// require_once 'config/database.php';

$category_id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

// Fetch category title
$category_query = "SELECT * FROM categories WHERE id = $category_id";
$category_result = mysqli_query($connection, $category_query);
$category = mysqli_fetch_assoc($category_result);

if (!$category) {
     echo "<p>Category not found.</p>";
} else {
     echo "<h2>{$category['title']} Posts</h2>";

     // Fetch posts under this category
     $posts_query = "SELECT * FROM posts WHERE category_id = $category_id ORDER BY date_time DESC";
     $posts_result = mysqli_query($connection, $posts_query);

     if (mysqli_num_rows($posts_result) > 0) {
          while ($post = mysqli_fetch_assoc($posts_result)) {
?>
               <div class="post__card">
                    <img src="./images/<?= htmlspecialchars($post['thumbnail']) ?>" alt=""></a>
                    <!-- <a href=""> <h3>?= htmlspecialchars($post['title']) ?></h3> -->
                    <h3>
                         <a href="post.php?id=<?= $post['id'] ?>">
                              <?= htmlspecialchars($post['title']) ?>
                         </a>
                    </h3>
                    <p><?= htmlspecialchars(substr($post['body'], 0, 100)) ?>...</p>
                    <button class="btn"><a href="post.php?id=<?= $post['id'] ?>">Read more</a></button>
               </div>
<?php
          }
     } else {
          echo "<p>No posts found in this category.</p>";
     }
}

require 'partials/footer.php';
?>