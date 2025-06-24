<?php
require 'config/database.php';
// session_start(); // Make sure the session is started

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
     // Sanitize and validate input
     $id = filter_var($_POST['id'], FILTER_VALIDATE_INT);
     $title = trim(filter_var($_POST['title'], FILTER_SANITIZE_FULL_SPECIAL_CHARS));
     $description = trim(filter_var($_POST['description'], FILTER_SANITIZE_FULL_SPECIAL_CHARS));

     // Input validation
     if (!$id || !$title || !$description) {
          $_SESSION['edit-category-error'] = "Invalid input. Please fill in all fields.";
     } else {
          // Prepared statement to prevent SQL injection
          $stmt = $connection->prepare("UPDATE categories SET title = ?, description = ? WHERE id = ?");
          if ($stmt) {
               $stmt->bind_param("ssi", $title, $description, $id);
               $success = $stmt->execute();

               if ($success) {
                    $_SESSION['edit-category-success'] = "Category '{$title}' updated successfully.";
               } else {
                    $_SESSION['edit-category-error'] = "Failed to update category.";
               }

               $stmt->close();
          } else {
               $_SESSION['edit-category-error'] = "Failed to prepare database statement.";
          }
     }
}

// Redirect to manage-categories page
header("Location: " . ROOT_URL . "admin/manage-categories.php");
exit();
