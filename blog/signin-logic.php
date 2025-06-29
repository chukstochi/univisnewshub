<?php
require 'config/database.php';

if (isset($_POST['submit'])) {
     // get the form data
     $username_email = filter_var($_POST['username_email'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
     $password = filter_var($_POST['password'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

     //   check for empty fields
     if (!$username_email) {
          $_SESSION['signin'] = "Please enter your username or email";
     } elseif (!$password) {
          $_SESSION['signin'] = "Please enter your password";
     } else {
          // fech user data from the database
          $fetch_user_query = "SELECT * FROM users WHERE username='$username_email' OR email='$username_email'";
          $fetch_user_result = mysqli_query($connection, $fetch_user_query);

          if (mysqli_num_rows($fetch_user_result) == 1) {
               // convert the record to an associative array
               $user_record = mysqli_fetch_assoc($fetch_user_result);
               $db_password = $user_record['password'];

               // verify the password
               if (password_verify($password, $db_password)) {
                    // set session for accesss control
                    $_SESSION['user-id'] = $user_record['id'];
                    // set session if user is an admin
                    if ($user_record['is_admin'] == 1) {
                         $_SESSION['user_is_admin'] = true;
                    }

                    //   log user in
                    header('location: ' . ROOT_URL . 'admin/');
               } else {
                    $_SESSION['signin'] = "please check your input";
               }
          } else {
               $_SESSION['signin'] = "User not found";
          }
     }
     // if any problem, redirect back to signin page with a signin data
     if (isset($_SESSION['signin'])) {
          $_SESSION['signin-data'] = $_POST;
          header('location: ' . ROOT_URL . 'signin.php');
          die();
     }
} else {
     header('location: ' . ROOT_URL . 'signin.php');
     die();
}
