<?php
require 'config/database.php';

if (isset($_POST['reset-password'])) {
     $token = mysqli_real_escape_string($connection, $_POST['token']);
     $new_password = mysqli_real_escape_string($connection, $_POST['new_password']);
     $confirm_password = mysqli_real_escape_string($connection, $_POST['confirm_password']);

     if ($new_password !== $confirm_password) {
          echo "Passwords do not match.";
          exit();
     }

     // Hash new password
     $hashed = password_hash($new_password, PASSWORD_DEFAULT);

     // Update user
     $query = "UPDATE users SET password='$hashed', reset_token=NULL WHERE reset_token='$token'";
     $result = mysqli_query($connection, $query);

     if (mysqli_affected_rows($connection) > 0) {
          echo "Password successfully reset. <a href='signin.php'>Login here</a>";
     } else {
          echo "Invalid or expired token.";
     }
}
