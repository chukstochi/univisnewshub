<?php
require 'config/database.php';


if (isset($_SESSION['user-id'])) {
     $id = filter_var($_SESSION['user-id'], FILTER_SANITIZE_NUMBER_INT);
     $query = "SELECT avatar FROM users WHERE id=$id";
     $result = mysqli_query($connection, $query);
     $avatar = mysqli_fetch_assoc($result);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
     <meta charset="UTF-8">
     <meta http-equiv="X-UA-Compatible" content="IE=edge">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>Univista News Hub</title>

     <!-- Fonts & Icons -->
     <link href="https://fonts.googleapis.com/css?family=Poppins&display=swap" rel="stylesheet">
     <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

     <!-- Main CSS -->
     <link rel="stylesheet" href="<?= ROOT_URL ?>css/styles.css?v2 ">
</head>


<!-- NAVIGATION -->
<nav class="navbar">
     <div class="container nav__container">
          <!-- Logo -->
          <a href="<?= ROOT_URL ?>" class="nav__logo">
               <img src="<?= ROOT_URL ?>images/logo1.jpg" alt="Logo" class="nav__logo-img">
               <span>UNIVISTA NEWS HUB</span>
          </a>

          <!-- Toggle Buttons -->
          <button id="open__nav-btn" class="nav_toggle"><i class="bx bx-menu"></i></button>
          <button id="close__nav-btn" class="nav_toggle"><i class="bx bx-x"></i></button>

          <!-- Nav Links -->
          <ul class="nav__items">
               <li><a href="<?= ROOT_URL ?>ng-news.php">NG NEWS</a></li>
               <li><a href="<?= ROOT_URL ?>us-news.php">US NEWS</a></li>
               <li><a href="<?= ROOT_URL ?>world-news.php">WORLD NEWS</a></li>
               <li><a href="<?= ROOT_URL ?>sports-news.php">SPORTS</a></li>
               <li><a href="<?= ROOT_URL ?>more-category.php">MORE</a></li>
          </ul>

          <!-- User Profile or Signin -->
          <div class="nav__auth">
               <?php if (isset($_SESSION['user-id'])) : ?>
                    <div class="nav__profile" id="profileToggle">
                         <img src="<?= ROOT_URL . 'images/' . $avatar['avatar'] ?>" alt="User Avatar" class="avatar">
                         <ul class="profile__dropdown" id="profileDropdown">
                              <li><a href="<?= ROOT_URL ?>admin/index.php">Dashboard</a></li>
                              <li><a href="<?= ROOT_URL ?>logout.php">Logout</a></li>
                         </ul>
                    </div>
               <?php else : ?>
                    <a href="<?= ROOT_URL ?>signin.php" class="btn">Sign In</a>
               <?php endif ?>
          </div>
     </div>

     <!-- <button id="scrollLeft" class="scroll-btn">&#10094;</button> -->

     <div class="tab-bar2">
          <a href="<?= ROOT_URL ?>index.php" class="category__button">HOME</a>
          <a href="<?= ROOT_URL ?>ng-news.php" class="category__button">NG NEWS</a>
          <a href="<?= ROOT_URL ?>us-news.php" class="category__button">US NEWS</a>
          <a href="<?= ROOT_URL ?>world-news.php" class="category__button">WORLD NEWS</a>
          <a href="<?= ROOT_URL ?>sports-news.php" class="category__button">SPORTS</a>
          <a href="<?= ROOT_URL ?>us-stock-market.php" class="category__button">US Stock Market</a>
          <a href="<?= ROOT_URL ?>more-category.php" class="category__button">MORE</a>
     </div>

     <!-- <button id="scrollRight" class="scroll-btn">&#10095;</button> -->

</nav>

<body>