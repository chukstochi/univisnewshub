<?php
// session_start();
// require 'config/database.php';
include 'partials/header.php';

// Fetch all users from the database
$query = "SELECT id, firstname, lastname, username, email, is_admin FROM users ORDER BY id DESC";
$result = mysqli_query($connection, $query);

if (!$result) {
     die("Query failed: " . mysqli_error($connection));
}
?>

<!-- Display session messages -->
<?php if (isset($_SESSION['edit-user-success'])): //show if edit user was successful 
?>
     <div class="alert__message success container">
          <?= htmlspecialchars($_SESSION['edit-user-success']) ?>
          <?php unset($_SESSION['edit-user-success']); ?>
     </div>
<?php elseif (isset($_SESSION['edit-user'])): //show if edit user was NOT successful 
?>
     <div class="alert_message error container">
          <?= $_SESSION['edit-user'] ?>
          <?php unset($_SESSION['edit-user']); ?>
     </div>
<?php elseif (isset($_SESSION['delete-user'])): //show if edelete user was NOT successful 
?>
     <div class="alert_message error container">
          <?= $_SESSION['delete-user'] ?>
          <?php unset($_SESSION['delete-user']); ?>
     </div>
<?php elseif (isset($_SESSION['delete-user'])): //show if edit user was NOT successful 
?>
     <div class="alert_message success container">
          <?= $_SESSION['delete-user-success'] ?>
          <?php unset($_SESSION['delete-user-success']); ?>
     </div>
<?php endif; ?>


<section class="dashboard">
     <?php if (isset($_SESSION['add-user-success'])):  //show if add user was successful
     ?>
          <div class="alert-message success container">
               <P>
                    <?= htmlspecialchars($_SESSION['add-user-success']) ?>
                    <?php unset($_SESSION['add-user-success']); ?>
               </P>
          </div>
     <?php endif ?>
     <div class="container dashboard__container">
          <h2>Manage Users</h2>

          <?php if (mysqli_num_rows($result) > 0): ?>
               <div>
                    <table class="user__table">
                         <thead>
                              <tr>
                                   <th>Name</th>
                                   <th>Username</th>
                                   <th>Email</th>
                                   <th>Role</th>
                                   <th>Actions</th>
                              </tr>
                         </thead>
                         <tbody>
                              <?php while ($user = mysqli_fetch_assoc($result)): ?>
 
                                   <tr>
     <td data-label="Name"><?= htmlspecialchars($user['firstname'] . ' ' . $user['lastname']) ?></td>
     <td data-label="Username"><?= htmlspecialchars($user['username']) ?></td>
     <td data-label="Email"><?= htmlspecialchars($user['email']) ?></td>
     <td data-label="Role"><?= $user['is_admin'] ? 'Admin' : 'Author' ?></td>
     <td data-label="Actions">
          <a href="<?= ROOT_URL ?>admin/edit-user.php?id=<?= $user['id'] ?>" class="btn sm">Edit</a>
          <a href="<?= ROOT_URL ?>admin/delete-user.php?id=<?= $user['id'] ?>" class="btn sm danger">Delete</a>
     </td>
</tr>


                                   <!-- <tr>
                                        <td data-label="Name">?= htmlspecialchars($user['firstname'] . ' ' . $user['lastname']) ?></td>
                                        <td data-label="Username">?= htmlspecialchars($user['username']) ?></td>
                                        <td data-label="Email">?= htmlspecialchars($user['email']) ?></td>
                                        <td data-label="Role">?= $user['is_admin'] ? 'Admin' : 'Author' ?></td>
                                        <td data-label="Actions">
                                             <a href="?= ROOT_URL ?>admin/edit-user.php?id=?= $user['id'] ?>" class="btn sm">Edit</a>
                                             <a href="?= ROOT_URL ?>admin/delete-user.php?id=?= $user['id'] ?>" class="btn sm danger">Delete</a>
                                        </td>
                                   </tr> -->
                              <?php endwhile; ?>
                         </tbody>
                    </table>
               </div>
          <?php else: ?>
               <p>No users found.</p>
          <?php endif; ?>
     </div>
</section>

<?php include 'partials/footer.php'; ?>