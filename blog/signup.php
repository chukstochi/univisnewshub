<?php
require 'config/constant.php';

// get back form data if there was a registration error
$firstname = $_SESSION['signup-data']['firstname'] ?? null;
$lastname = $_SESSION['signup-data']['lastname'] ?? null;
$username = $_SESSION['signup-data']['username'] ?? null;
$email = $_SESSION['signup-data']['email'] ?? null;
$createpassword = $_SESSION['signup-data']['createpassword'] ?? null;
$confirmpassword = $_SESSION['signup-data']['confirmpassword'] ?? null;
// delete the signup data session

unset($_SESSION['signup-data']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
     <meta charset="UTF-8">
     <meta http-equiv="X-UA-Compatible" content="IE=edge">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
     <link href='https://unpkg.com/boxicons/css/boxicons.min.css' rel="stylesheet">
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
     <!-- href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0&icon_names=menu" /> -->
     <title>univistanewshub</title>

     <!-- style css -->
     <link rel="stylesheet" href="./css/styles.css">
</head>

<body>


     <section class="form__section">
          <div class="container form__section-container">
               <h2>Sign Up</h2>

               <?php if (isset($_SESSION['signup'])) : ?>
                    <div class="alert__message error">
                         <p>
                              <?= $_SESSION['signup'];
                              unset($_SESSION['signup']);
                              ?>

                         </p>
                    </div>

               <?php
               endif
               ?>
               <form action="<?= ROOT_URL ?>signup-logic.php" enctype="multipart/form-data" method="POST">
                    <input type="text" name="firstname" value="<?= $firstname ?>" placeholder=" First Name">
                    <input type="text" name="lastname" value="<?= $lastname ?>" placeholder=" Last Name">
                    <input type="text" name="username" value="<?= $username ?>" placeholder=" userName">
                    <input type="email" name="email" value="<?= $email ?>" placeholder="Email">
                    <input type="password" name="createpassword" value="<?= $createpassword ?>" placeholder="Create Password">
                    <input type="password" name="confirmpassword" value="<?= $confirmpassword ?>" placeholder="Confirm Password">
                    <div class="form__control">
                         <label for="avatar">User Avatar</label>
                         <input type="file" name="avatar" id="avatar">
                    </div>
                    <button type="submit" name="submit" class="btn">Sign Up</button>
                    <small>Already have an account? <a href="signin.php"> Sign In</a></small>
               </form>

          </div>


     </section>

</body>

</html>