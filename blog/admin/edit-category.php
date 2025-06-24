<?php
include 'partials/header.php';
// session_start(); // just in case it's not already started

if (isset($_GET['id'])) {
     $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

     // fetch category from database
     $query = "SELECT * FROM categories WHERE id=$id";
     $result = mysqli_query($connection, $query);
     if (mysqli_num_rows($result) === 1) {
          $category = mysqli_fetch_assoc($result);
     } else {
          $_SESSION['edit-category-error'] = "Category not found.";
          header('location: ' . ROOT_URL . 'admin/manage-categories.php');
          exit();
     }
} else {
     header('location: ' . ROOT_URL . 'admin/manage-categories.php');
     exit();
}
?>

<section class="form__section">

     <div class="container form__section-container">
          <h2>Edit Category</h2>

          <!-- Display session error if available -->
          <?php if (isset($_SESSION['edit-category-error'])): ?>
               <div class="form__error-message">
                    <?= $_SESSION['edit-category-error'];
                    unset($_SESSION['edit-category-error']); ?>
               </div>
          <?php endif; ?>

          <form action="<?= ROOT_URL ?>admin/edit-category-logic.php" method="POST">
               <!-- Hidden input for ID -->
               <input type="hidden" name="id" value="<?= $category['id'] ?>">

               <input type="text" name="title" value="<?= $category['title'] ?>" placeholder="Title" required>

               <textarea name="description" rows="4" placeholder="Description" required><?= $category['description'] ?></textarea>

               <button type="submit" name="submit" class="btn">Update Category</button>
          </form>
     </div>
</section>

<?php include '../partials/footer.php'; ?>