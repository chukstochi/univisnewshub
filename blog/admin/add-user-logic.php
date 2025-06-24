<?php
require 'config/database.php';

// Run only if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
     // Sanitize inputs
     $firstname = filter_var(trim($_POST['firstname']), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
     $lastname = filter_var(trim($_POST['lastname']), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
     $username = filter_var(trim($_POST['username']), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
     $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
     $createpassword = $_POST['createpassword'];
     $confirmpassword = $_POST['confirmpassword'];
     $is_admin = filter_var($_POST['userrole'], FILTER_SANITIZE_NUMBER_INT);
     $avatar = $_FILES['avatar'];

     // Save input back to session in case of error
     $_SESSION['add-user-data'] = $_POST;

     // Validate inputs
     if (!$firstname || !$lastname || !$username || !$email) {
          $_SESSION['add-user'] = "Please fill in all required fields.";
     } elseif (strlen($createpassword) < 8 || strlen($confirmpassword) < 8) {
          $_SESSION['add-user'] = "Password should be at least 8 characters long.";
     } elseif ($createpassword !== $confirmpassword) {
          $_SESSION['add-user'] = "Passwords do not match.";
     } elseif (!$avatar['name']) {
          $_SESSION['add-user'] = "Please upload an avatar image.";
     } else {
          // Check file extension
          $allowed_extensions = ['png', 'jpg', 'jpeg'];
          $extension = strtolower(pathinfo($avatar['name'], PATHINFO_EXTENSION));
          if (!in_array($extension, $allowed_extensions)) {
               $_SESSION['add-user'] = "Avatar must be a PNG, JPG, or JPEG image.";
          } elseif ($avatar['size'] > 2 * 1024 * 1024) { // 2MB
               $_SESSION['add-user'] = "Avatar size should be under 2MB.";
          } else {
               // Check if user already exists (by email or username)
               $stmt = $connection->prepare("SELECT id FROM users WHERE email = ? OR username = ?");
               $stmt->bind_param("ss", $email, $username);
               $stmt->execute();
               $stmt->store_result();
               if ($stmt->num_rows > 0) {
                    $_SESSION['add-user'] = "A user with that email or username already exists.";
               } else {
                    // All good: move file and insert user
                    $time = time();
                    $avatar_name = $time . '_' . basename($avatar['name']);
                    $avatar_path = '../images/' . $avatar_name;
                    move_uploaded_file($avatar['tmp_name'], $avatar_path);

                    // Hash password
                    $hashed_password = password_hash($createpassword, PASSWORD_DEFAULT);

                    // Insert user using prepared statement
                    $stmt = $connection->prepare(
                         "INSERT INTO users (firstname, lastname, username, email, password, avatar, is_admin)
                     VALUES (?, ?, ?, ?, ?, ?, ?)"
                    );
                    $stmt->bind_param('ssssssi', $firstname, $lastname, $username, $email, $hashed_password, $avatar_name, $is_admin);
                    $stmt->execute();

                    if ($stmt->affected_rows === 1) {
                         unset($_SESSION['add-user-data']);
                         $_SESSION['add-user-success'] = "New user $firstname $lastname added successfully.";
                         header('Location: ' . ROOT_URL . 'admin/manage-user.php');
                         exit();
                    } else {
                         $_SESSION['add-user'] = "Something went wrong. Please try again.";
                    }
               }
               $stmt->close();
          }
     }

     // If any error occurred, redirect back
     header('Location: ' . ROOT_URL . 'admin/add-user.php');
     exit();
} else {
     // If not submitted via POST, redirect to form
     header('Location: ' . ROOT_URL . 'admin/add-user.php');
     exit();
}








// <!-- ?php
     // require 'config/database.php';

     //get signup form data if submit button is clicked

     // if (isset($_POST['submit'])) {
          // $firstname = filter_var(($_POST['firstname']), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
          // $lastname = filter_var(($_POST['lastname']), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
          // $username = filter_var(($_POST['username']), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
         // $email = filter_var(($_POST['email']), FILTER_SANITIZE_EMAIL);
         // $createpassword = filter_var(($_POST['createpassword']), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
         // $confirmpassword = filter_var(($_POST['confirmpassword']), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        //  $is_admin = filter_var($_POST['userrole'], FILTER_SANITIZE_NUMBER_INT);
       //   $avatar = $_FILES['avatar'];


          //validate input values
        //  if (!$firstname) {
       //        $_SESSION['add-user'] = "Please enter your First Name";
       //   } elseif (!$lastname) {
        //       $_SESSION['add-user'] = "Please enter your Last Name";
       //   } elseif (!$username) {
         //      $_SESSION['add-user'] = "Please enter your Username";
        //  } elseif(!$email) {
         //      $_SESSION['add-user'] = "Please enter your Email";
         // }
          //      } elseif (!$is_admin) 
          //           // $_SESSION['add-user'] = "Please select user role";}

         // elseif (strlen($createpassword) < 8 || strlen($confirmpassword) < 8) {
           //    $_SESSION['add-user'] = "password should be 8+ characters long";
          //} elseif (!$avatar['name']) {
         //      $_SESSION['add-user'] = "Please add an Avatar";
        //  } else
               //check if passwords match
        //       if ($createpassword !== $confirmpassword) {
         //           $_SESSION['add-user'] = "Passwords do not match";
         //      } else {
                    //hash password
         //           $hashed_password = password_hash($createpassword, PASSWORD_DEFAULT);

                    //check if user already exists in database
          //          $user_check_query = "SELECT * FROM users WHERE email='$email' OR username='$username'";
            //        $user_check_result = mysqli_query($connection, $user_check_query);
            //        if (mysqli_num_rows($user_check_result) > 0) {
            //             $_SESSION['add-user'] = "User with this email or username already exists";
             //       } else {
                         //set avatar name
             //            $time = time();
              //           $avatar_name = $time . $avatar['name'];
               //          $avatar_tmp_name = $avatar['tmp_name'];
               //          $avatar_destination_path = '../images/' . $avatar_name;

                         //make sure file is an image
               //          $allowed_files = ['png', 'jpg', 'jpeg'];
                 //        $extension = explode('.', $avatar_name);
                  //       $extension = end($extension);


                  //       if (in_array($extension, $allowed_files)) {
                              //make sure image is not too large (1mb+)
                     //         if ($avatar['size'] < 2000000) {
                      //             move_uploaded_file($avatar_tmp_name, $avatar_destination_path);
                       //       } else {
                      //             $_SESSION['add-user'] = "File size too large. Should be less than 1mb";
                       //       }
                       //  } else {
                         //     $_SESSION['add-user'] = "File should be png, jpg or jpeg";
                        // }
                  //  }
              // }

          // redirect back to add-user page if there was any problem
         // if (isset($_SESSION['add-user'])) {
               // pass form data back to signup page
          //     $_SESSION['add-user-data'] = $_POST;
            //   header('location: ' . ROOT_URL . '/admin/add-user.php');
            //   die();
         // } else {
               //insert new user into users table
         //      $insert_user_query = "INSERT INTO users SET firstname='$firstname',
           // lastname='$lastname', username='$username', 
           // email='$email', password='$hashed_password',
           // avatar='$avatar_name', is_admin=$is_admin";
            //   $insert_user_result = mysqli_query($connection, $insert_user_query);

            //   if (!mysqli_errno($connection)) {
                    //redirect to login page with success message
             //       $_SESSION['add-user-success'] = "New user $firstname $lastname added successfully";
                //    header('location: ' . ROOT_URL . 'admin/manage-user.php');
                //    die();
               //}
         // }
     //} else {
          //if button is not clicked, redirect to signup page
     //     header('location: ' . ROOT_URL . 'admin/add-user.php');
     //     die();
    // } -->