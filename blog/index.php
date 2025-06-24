<?php
// require_once 'partials/header.php';
// require_once 'config/database.php';
require_once 'category-section.php'; // put the function in this file

// Fetch top 3 featured posts
$top_featured_query = "SELECT * FROM posts WHERE is_featured = 1 ORDER BY date_time DESC LIMIT 3";
$top_featured_result = mysqli_query($connection, $top_featured_query);
?>
<section class="top-featured">
     <div class="container top-featured-container">
          <?php while ($feat = mysqli_fetch_assoc($top_featured_result)) : ?>
               <div class="top-card">
                    <img src="./images/<?= $feat['thumbnail'] ?>" alt="<?= $feat['title'] ?>">
                    <div class="card-text">
                         <h3><a href="post.php?id=<?= $feat['id'] ?>"><?= htmlspecialchars($feat['title']) ?></a></h3>
                         <!-- <p>?= htmlspecialchars(substr($feat['body'], 0, 80)) ?>...</p> -->
                    </div>
               </div>
          <?php endwhile; ?>
     </div>
</section>
<?php
// Render sections for each category
render_category_section('NG NEWS', 'ng-news');
render_category_section('US NEWS', 'us-news');
render_category_section('WORLD NEWS', 'world-news');
render_category_section('SPORTS', 'sports');
?>

<?php include 'partials/footer.php'; ?>