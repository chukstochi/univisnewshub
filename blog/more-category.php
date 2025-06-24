<?php
require "partials/header.php";
// require_once "config/database.php"; // Ensure database connection is included
?>

<section class="category__buttons">
     <div class="container category__buttons-container">
          <?php
          // Fetch all categories
          $all_categories_query = "SELECT * FROM categories";
          $all_categories_result = mysqli_query($connection, $all_categories_query);

          // Check if any categories exist
          if (mysqli_num_rows($all_categories_result) > 0) :
               while ($category = mysqli_fetch_assoc($all_categories_result)) :
                    // Sanitize output
                    $category_id = htmlspecialchars($category['id']);
                    $category_title = htmlspecialchars($category['title']);
          ?>
                    <a href="<?= ROOT_URL ?>category-posts.php?id=<?= $category_id ?>" class="category__button">
                         <?= $category_title ?>
                    </a>
          <?php
               endwhile;
          else :
               echo "<p>No categories found.</p>";
          endif;
          ?>
     </div>
</section>

<?php include 'partials/footer.php'; ?>