<?php
require 'config/database.php';

if (isset($_POST['reset-request'])) {
     $email = mysqli_real_escape_string($connection, $_POST['email']);

     $user_check_query = "SELECT * FROM users WHERE email='$email' LIMIT 1";
     $result = mysqli_query($connection, $user_check_query);

     if (mysqli_num_rows($result) === 1) {
          $token = bin2hex(random_bytes(50)); // generates a random token
          $update_query = "UPDATE users SET reset_token='$token' WHERE email='$email'";
          mysqli_query($connection, $update_query);

          // Show token manually (for local development)
          echo "Use this link to reset your password:<br>";
          echo "<a href='reset-password.php?token=$token'>Reset Password</a>";
     } else {
          echo "Email not found.";
     }
}
