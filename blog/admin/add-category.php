<?php
include 'partials/header.php';

// Get and preserve form data
$title = $_SESSION['add-category-data']['title'] ?? '';
$description = $_SESSION['add-category-data']['description'] ?? '';

// Get error message(s)
$error = $_SESSION['add-category-error'] ?? null;
$success = $_SESSION['add-category-success'] ?? null;

// Clear session messages
unset($_SESSION['add-category-data'], $_SESSION['add-category-error'], $_SESSION['add-category-success']);
?>

<section class="form__section">

     <div class="container form__section-container">
          <h2>Add Category</h2>

          <?php if ($success): ?>
               <div class="alert__message success">
                    <p><?= $success ?></p>
               </div>
          <?php elseif ($error): ?>
               <div class="alert__message error">
                    <p><?= $error ?></p>
               </div>
          <?php endif; ?>

          <form action="<?= ROOT_URL ?>admin/add-category-logic.php" method="POST">
               <input
                    type="text"
                    name="title"
                    value="<?= htmlspecialchars($title) ?>"
                    placeholder="Title"
                    required>
               <textarea
                    rows="4"
                    name="description"
                    placeholder="Description"
                    required><?= htmlspecialchars($description) ?></textarea>
               <button type="submit" name="submit" class="btn">Add Category</button>
          </form>
     </div>
</section>

<?php include './partials/footer.php'; ?>