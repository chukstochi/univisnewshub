<?php
include 'partials/header.php';

// Fetch categories
$categories = [];
$category_query = "SELECT * FROM categories ORDER BY title ASC";
$category_result = mysqli_query($connection, $category_query);
if ($category_result && mysqli_num_rows($category_result) > 0) {
     $categories = mysqli_fetch_all($category_result, MYSQLI_ASSOC);
}

// Get old form values
$form_data = $_SESSION['add-post-data'] ?? [];
$title = $form_data['title'] ?? '';
$body = $form_data['body'] ?? '';
$category_id = $form_data['category'] ?? '';

// Get error messages
$errors = $_SESSION['add-post-errors'] ?? [];

// Clear session after retrieval
unset($_SESSION['add-post-data'], $_SESSION['add-post-errors']);
?>

<section class="form__section">
     <div class="container form__section-container">
          <h2>Add Post</h2>

          <?php if (!empty($errors)): ?>
               <div class="alert__message error">
                    <ul>
                         <?php foreach ($errors as $error): ?>
                              <li><?= htmlspecialchars($error) ?></li>
                         <?php endforeach; ?>
                    </ul>
               </div>
          <?php endif; ?>

          <form action="<?= ROOT_URL ?>admin/add-post-logic.php" method="POST" enctype="multipart/form-data">
               <input type="text" name="title" value="<?= htmlspecialchars($title) ?>" placeholder="Title" required>

               <select name="category" required>
                    <option value="" disabled <?= $category_id ? '' : 'selected' ?>>Select Category</option>
                    <?php foreach ($categories as $cat): ?>
                         <option value="<?= $cat['id'] ?>" <?= $cat['id'] == $category_id ? 'selected' : '' ?>>
                              <?= htmlspecialchars($cat['title']) ?>
                         </option>
                    <?php endforeach; ?>
               </select>

               <textarea rows="10" name="body" placeholder="Body" required><?= htmlspecialchars($body) ?></textarea>

               <?php if (!empty($_SESSION['user_is_admin'])): ?>
                    <div class="form__control inline">
                         <input type="checkbox" name="is_featured" value="1" id="is_featured">
                         <label for="is_featured">Featured</label>
                    </div>
               <?php endif; ?>

               <div class="form__control">
                    <label for="thumbnail">Add Thumbnail</label>
                    <input type="file" name="thumbnail" id="thumbnail" required>
               </div>

               <button type="submit" name="submit" class="btn">Add Post</button>
          </form>
     </div>
</section>

<?php include 'partials/footer.php'; ?>