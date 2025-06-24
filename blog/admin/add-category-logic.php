<?php
require '../config/database.php';
// session_start();

if (isset($_POST['submit'])) {
     $title = trim($_POST['title']);
     $description = trim($_POST['description']);

     $_SESSION['add-category-data'] = [
          'title' => $title,
          'description' => $description
     ];

     // Validate input
     if (empty($title) || empty($description)) {
          $_SESSION['add-category-error'] = "All fields are required.";
          header("Location: " . ROOT_URL . "admin/add-category.php");
          exit;
     }

     // Insert into DB using prepared statement
     $stmt = $connection->prepare("INSERT INTO categories (title, description) VALUES (?, ?)");
     if ($stmt) {
          $stmt->bind_param("ss", $title, $description);
          if ($stmt->execute()) {
               $_SESSION['add-category-success'] = "Category added successfully!";
               unset($_SESSION['add-category-data']);
          } else {
               $_SESSION['add-category-error'] = "Database error: " . $stmt->error;
          }
          $stmt->close();
     } else {
          $_SESSION['add-category-error'] = "Failed to prepare database statement.";
     }

     header("Location: " . ROOT_URL . "admin/add-category.php");
     exit;
} else {
     header("Location: " . ROOT_URL . "admin/add-category.php");
     exit;
}




















// <?=php
// require 'config/database.php';

// if (isset($_POST['submit'])) {
//      //get a form data
//      $title = filter_var($_POST['title'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
//      $description = filter_var(
//           $_POST['description'],
//           FILTER_SANITIZE_FULL_SPECIAL_CHARS
//      );

//      if (!$isset) {
//           $_SESSION['add-category'] = "Enter Title";
//      } elseif (!$description) {
//           $_SESSION['add-category'] = "Enter Description";
//      }
//      // redirect back to add category Page with form data if there is an invalid input.
//      if (isset($_SESSION['add-category'])) {
//           $_SESSION['add-category-data'] = $_POST;
//           header('location: ' . ROOT_URL . 'admin/add-category.php');
//           die();
//      } else {
//           // insert category into database
//           $query = "INSERT INTO categories (title, description)
//           VALUE('$title', '$description')";
//           $result = mysqli_query($connection, $query);
//           if (mysqli_errno($connection)) {
//                $_SESSION['add-category'] = "couldn't  add category";
//                header('location: ' . ROOT_URL . 'admin/add-category.php');
//                die();
//           } else {
//                $_SESSION['add-category-success'] = 'category $title added successfully';
//                header('location: ' . ROOT_URL . 'admin/manage-categories.php');
//                die();
//           }
//      }
// }
