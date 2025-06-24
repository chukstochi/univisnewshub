<?php
require 'config/constant.php';
$username_email = $_SESSION['signin-data']['username_email'] ?? null;
$password = $_SESSION['signin-data']['password'] ?? null;

unset($_SESSION['signin-data']);
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
               <h2>Sign In</h2>
               <?php if (isset($_SESSION['signup-success'])) : ?>
                    <div class="alert__message success">
                         <p> <?= $_SESSION['signup-success'];
                              unset($_SESSION['signup-success']); ?>
                         </p>
                    </div>
               <?php elseif (isset($_SESSION['signin'])) : ?>
                    <div class="alert__message error">
                         <p> <?= $_SESSION['signin'];
                              unset($_SESSION['signin']); ?>
                         </p>
                    </div>
               <?php endif ?>
               <form action="<?= ROOT_URL ?>signin-logic.php" method="POST">
                    <input type="text" name="username_email" value="<?= $username_email ?>" placeholder="UserName or Email">
                    <input type="password" name="password" value="<?= $password ?>" placeholder="password">
                    <button type="submit" name="submit" class="btn">Sign In</button>
                    <small>Forgot Password? <a href="forgot-password.php"> Reset</a></small>
                    <small>Don't have an account? <a href="signup.php"> Sign Up</a></small>
               </form>
          </div>

     </section>
</body>

</html>