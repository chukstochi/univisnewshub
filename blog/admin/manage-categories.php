<?php
include '../partials/header.php';
// require '../config/database.php'; // Ensure database connection

// fetch categories from database
$query = "SELECT * FROM categories ORDER BY title";
$categories = mysqli_query($connection, $query);
?>

<section class="dashboard">
     <?php if (isset($_SESSION['add-category-success'])):  //show if add user was successful
     ?>
          <div class="alert-message success container">
               <P>
                    <?= htmlspecialchars($_SESSION['add-category-success']) ?>
                    <?php unset($_SESSION['add-category-success']); ?>
               </P>
          </div>
     <?php elseif (isset($_SESSION['add-category'])):  //show if add user was not successful
     ?>
          <div class="alert-message success container">
               <P>
                    <?= htmlspecialchars($_SESSION['add-category']) ?>
                    <?php unset($_SESSION['add-category']); ?>
               </P>
          </div>
     <?php endif ?>
     <div class="container dashboard__container">
          <button id="show_sidebar-btn" class="sidebar_toggle"><i class="fa-solid fa-arrow-right"></i></button>
          <button id="hide_sidebar-btn" class="hidebar_toggle"><i class="fa-solid fa-arrow-left"></i></button>

          <aside>
               <ul>
                    <li><a href="add-post.php"><i class='bx bx-pen'></i>
                              <h5>Add Post</h5>
                         </a></li>
                    <li><a href="index.php"><i class='bx bx-edit'></i>
                              <h5>Manage Posts</h5>
                         </a></li>

                    <?php if (isset($_SESSION['user_is_admin'])): ?>
                         <li><a href="add-user.php"><i class="fa-solid fa-user-plus"></i>
                                   <h5>Add User</h5>
                              </a></li>
                         <li><a href="manage-user.php"><i class="fa-solid fa-user"></i>
                                   <h5>Manage Users</h5>
                              </a></li>
                         <li><a href="add-category.php"><i class="fa-solid fa-list-ol"></i>
                                   <h5>Add Category</h5>
                              </a></li>
                         <li><a href="manage-categories.php" class="active"><i class="fa-solid fa-list"></i>
                                   <h5>Manage Categories</h5>
                              </a></li>
                    <?php endif; ?>

                    <li><a href="add-tag.php"><i class="fa-solid fa-tags"></i>
                              <h5>Add Tag</h5>
                         </a></li>
                    <li><a href="manage-tags.php"><i class="fa-solid fa-user-tag"></i>
                              <h5>Manage Tags</h5>
                         </a></li>
                    <li><a href="logout.php"><i class="fa-solid fa-right-from-bracket"></i>
                              <h5>Logout</h5>
                         </a></li>
               </ul>
          </aside>

          <main>
               <h2>Manage Categories</h2>

               <?php if (mysqli_num_rows($categories) > 0): ?>
                    <div class="alert__message success container">
                         <?= mysqli_num_rows($categories) ?> categories found.
                    </div>

                    <table>
                         <thead>
                              <tr>
                                   <th>Title</th>
                                   <th>Edit</th>
                                   <th>Delete</th>
                              </tr>
                         </thead>
                         <tbody>
                              <?php while ($category = mysqli_fetch_assoc($categories)) : ?>
                                   <tr>
                                        <td><?= htmlspecialchars($category['title']) ?></td>
                                        <td><a href="edit-category.php?id=<?= $category['id'] ?>" class="btn sm">Edit</a></td>
                                        <td><a href="delete-category.php?id=<?= $category['id'] ?>" class="btn sm danger">Delete</a></td>
                                   </tr>
                              <?php endwhile; ?>
                         </tbody>
                    </table>

               <?php else : ?>
                    <div class="alert__message error container">
                         <p>No categories found. <a href="<?= ROOT_URL ?>admin/add-category.php">Add a new category</a>.</p>
                    </div>
               <?php endif; ?>
          </main>
     </div>
</section>

<?php include '../partials/footer.php'; ?>