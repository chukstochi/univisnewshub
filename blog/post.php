<?php
require 'partials/header.php';
// require_once 'config/database.php'; // Ensure database connection

// Fetch post from database if id is set
if (isset($_GET['id']) && filter_var($_GET['id'], FILTER_VALIDATE_INT)) {
     $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

     // Fetch post
     $query = "SELECT * FROM posts WHERE id=$id";
     $result = mysqli_query($connection, $query);

     if (mysqli_num_rows($result) === 1) {
          $post = mysqli_fetch_assoc($result);
     } else {
          header('Location: ' . ROOT_URL . 'index.php');
          exit();
     }
} else {
     header('Location: ' . ROOT_URL . 'index.php');
     exit();
}
?>

<section class="singlepost">
     <div class="container singlepost__container">
          <!-- Post Title -->
          <h2><?= htmlspecialchars($post['title']) ?></h2>

          <!-- Post Thumbnail -->
          <div class="singlepost__thumbnail">
               <img src="images/<?= htmlspecialchars($post['thumbnail']) ?>" alt="Post Thumbnail" style="width: 100%; height: auto; border-radius: 10px;">
          </div>

          <!-- Post Body -->
          <div class="post__body">
               <p><?= nl2br(htmlspecialchars($post['body'])) ?></p>
          </div>

          <!-- Author Information -->
          <?php
          $author_id = $post['author_id'];
          $author_query = "SELECT * FROM users WHERE id=$author_id";
          $author_result = mysqli_query($connection, $author_query);

          if ($author_result && mysqli_num_rows($author_result) === 1) {
               $author = mysqli_fetch_assoc($author_result);
          ?>
               <div class="post__author">
                    <div class="post__author-avatar">
                         <img src="images/<?= htmlspecialchars($author['avatar']) ?>" alt="Author Avatar" style=" width: 100px; height: 100px; border-radius: 50%;">
                    </div>
                    <div class="post__author-info">
                         <h5>By: <?= htmlspecialchars($author['firstname'] . ' ' . $author['lastname']) ?></h5>
                         <small><?= date("M d, Y - H:i", strtotime($post['date_time'])) ?></small>
                    </div>
               </div>
          <?php } ?>
     </div>
</section>

<?php include 'partials/footer.php'; ?>