<?php
include 'partials/header.php';

// Redirect if post ID is not provided
if (!isset($_GET['id']) || !filter_var($_GET['id'], FILTER_VALIDATE_INT)) {
     header('Location: ' . ROOT_URL . 'admin/');
     exit();
}

$post_id = (int) $_GET['id'];

// Fetch post data
$post_query = "SELECT * FROM posts WHERE id = ?";
$stmt = $connection->prepare($post_query);
$stmt->bind_param("i", $post_id);
$stmt->execute();
$post_result = $stmt->get_result();
$post = $post_result->fetch_assoc();

if (!$post) {
     header('Location: ' . ROOT_URL . 'admin/');
     exit();
}

// Fetch categories
$categories_query = "SELECT * FROM categories ORDER BY title ASC";
$categories_result = mysqli_query($connection, $categories_query);
?>

<section class="form__section">
     <div class="container form__section-container">
          <h2>Edit Post</h2>

          <form action="<?= ROOT_URL ?>admin/edit-post-logic.php" method="POST" enctype="multipart/form-data">
               <input type="hidden" name="id" value="<?= $post_id ?>">

               <input type="text" name="title" value="<?= htmlspecialchars($post['title']) ?>" placeholder="Title" required>

               <select name="category" required>
                    <option disabled>Select Category</option>
                    <?php while ($category = mysqli_fetch_assoc($categories_result)): ?>
                         <option value="<?= $category['id'] ?>"
                              <?= $category['id'] == $post['category_id'] ? 'selected' : '' ?>>
                              <?= htmlspecialchars($category['title']) ?>
                         </option>
                    <?php endwhile; ?>
               </select>

               <textarea rows="10" name="body" placeholder="Body" required><?= htmlspecialchars($post['body']) ?></textarea>

               <div class="form__control inline">
                    <input type="checkbox" id="is_featured" name="is_featured" value="1"
                         <?= $post['is_featured'] ? 'checked' : '' ?>>
                    <label for="is_featured">Featured</label>
               </div>

               <div class="form__control">
                    <label for="thumbnail">Change Thumbnail</label>
                    <input type="file" name="thumbnail" id="thumbnail">
               </div>

               <button type="submit" name="submit" class="btn">Update Post</button>
          </form>
     </div>
</section>

<!-- ?php include 'partials/footer.php'; ? -->