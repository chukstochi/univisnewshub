<?php
include 'partials/header.php';

// Retrieve form data from session (if any)
$add_user_data = $_SESSION['add-user-data'] ?? [];
$firstname = htmlspecialchars($add_user_data['firstname'] ?? '');
$lastname = htmlspecialchars($add_user_data['lastname'] ?? '');
$username = htmlspecialchars($add_user_data['username'] ?? '');
$email = htmlspecialchars($add_user_data['email'] ?? '');

// Clear session form data after usage
unset($_SESSION['add-user-data']);
?>

<section class="form__section">
     <div class="container form__section-container">
          <h2>Add User</h2>

          <!-- Display error message if available -->
          <?php if (isset($_SESSION['add-user'])) : ?>
               <div class="alert__message error">
                    <p><?= $_SESSION['add-user'];
                         unset($_SESSION['add-user']); ?></p>
               </div>
          <?php endif; ?>

          <!-- User Form -->
          <form action="<?= ROOT_URL ?>admin/add-user-logic.php" method="POST" enctype="multipart/form-data">
               <input type="text" name="firstname" value="<?= $firstname ?>" placeholder="First Name" required>
               <input type="text" name="lastname" value="<?= $lastname ?>" placeholder="Last Name" required>
               <input type="text" name="username" value="<?= $username ?>" placeholder="Username" required>
               <input type="email" name="email" value="<?= $email ?>" placeholder="Email" required>

               <!-- Passwords should not be pre-filled -->
               <input type="password" name="createpassword" placeholder="Create Password" required minlength="8">
               <input type="password" name="confirmpassword" placeholder="Confirm Password" required minlength="8">

               <select name="userrole" required>
                    <option value="">Select Role</option>
                    <option value="0">Author</option>
                    <option value="1">Admin</option>
               </select>

               <div class="form__control">
                    <label for="avatar">User Avatar</label>
                    <input type="file" name="avatar" id="avatar" accept=".png,.jpg,.jpeg" required>
               </div>

               <button type="submit" name="submit" class="btn">Add User</button>
          </form>
     </div>
</section>

<?php
include 'partials/footer.php';
?>

















<!-- ?php
include 'partials/header.php';

// get back form data if there was an error 
$firstname = $_SESSION['add-user-data']['firstname'] ?? null;
$lastname = $_SESSION['add-user-data']['lastname'] ?? null;
$username = $_SESSION['add-user-data']['username'] ?? null;
$email = $_SESSION['add-user-data']['email'] ?? null;
$createpassword = $_SESSION['add-user-data']['createpassword'] ?? null;
$confirmpassword = $_SESSION['add-user-data']['confirmpassword'] ?? null;

// delete session data

unset($_SESSION['add-user-data']);
?>

<section class="form__section">
     <div class="container form__section-container">
          <h2>Add User</h2>
          ?php if (isset($_SESSION['add-user'])) : ?>
               <div class="alert__message error">
                    <p>
                         ?= $_SESSION['add-user'];
                         unset($_SESSION['add-user']);
                         ?>
                    </p>
               </div>
          ?php endif ?>
          <form action=" ?= ROOT_URL ?>admin/add-user-logic.php" enctype=" multipart/form-data" method="POST">

               <input type="text" name="firstname" value="?= $firstname ?>" placeholder="First Name">
               <input type="text" name="lastname" value="?= $lastname ?>" placeholder="Last Name">
               <input type="text" name="username" value="?= $username ?>" placeholder="User Name">
               <input type="email" name="email" value="?= $email ?>" placeholder="Email">
               <input type="password" name="createpassword" placeholder="Create password">
               <input type="password" name="confirmpassword" placeholder="confirm password">
               <select name="userrole">
                    <option value="0">Author</option>
                    <option value="1">Admin</option>
               </select>
               <div class="form__control">
                    <label for="avatar">User Avatar</label>
                    <input type="file" name="avatar" id="avatar">
               </div>
               <button type="submit" name="submit" class="btn">Add User</button>
          </form>
     </div>

</section>

?php
include './partials/footer.php';
?> -->