<?php
require 'config/database.php';

session_start();

// Only run if form was submitted
if (isset($_POST['submit'])) {
     // Get form values
     $title = trim($_POST['title'] ?? '');
     $body = trim($_POST['body'] ?? '');
     $category_id = filter_var($_POST['category'], FILTER_VALIDATE_INT);
     $author_id = $_SESSION['user-id'] ?? null;
     $is_featured = isset($_POST['is_featured']) ? 1 : 0;
     $thumbnail = $_FILES['thumbnail'] ?? null;

     // Store form data temporarily in case of error
     $_SESSION['add-post-data'] = [
          'title' => $title,
          'body' => $body,
          'category' => $category_id
     ];

     // Validation
     $errors = [];

     if (!$title) $errors[] = "Post title is required.";
     if (!$body) $errors[] = "Post body is required.";
     if (!$category_id) $errors[] = "Please select a valid category.";
     if (!$author_id) $errors[] = "You must be logged in to post.";
     if (!$thumbnail || $thumbnail['error'] !== 0) $errors[] = "Post thumbnail is required.";

     // If errors exist, redirect back
     if (!empty($errors)) {
          $_SESSION['add-post-errors'] = $errors;
          header('Location: ' . ROOT_URL . 'admin/add-post.php');
          exit;
     }

     // Handle thumbnail upload
     $thumbnail_name = time() . '-' . basename($thumbnail['name']);
     $thumbnail_tmp_path = $thumbnail['tmp_name'];
     $thumbnail_dest_path = '../images/' . $thumbnail_name;

     $allowed_types = ['image/png', 'image/jpeg', 'image/jpg', 'image/webp'];
     if (!in_array($thumbnail['type'], $allowed_types)) {
          $_SESSION['add-post-errors'] = ['Thumbnail must be a PNG, JPG, JPEG, or WEBP image.'];
          header('Location: ' . ROOT_URL . 'admin/add-post.php');
          exit;
     }

     if (!move_uploaded_file($thumbnail_tmp_path, $thumbnail_dest_path)) {
          $_SESSION['add-post-errors'] = ['Failed to upload thumbnail image.'];
          header('Location: ' . ROOT_URL . 'admin/add-post.php');
          exit;
     }

     // Set all posts as non-featured if this is marked as featured
     if ($is_featured === 1) {
          $connection->query("UPDATE posts SET is_featured = 0");
     }

     // Insert into database with prepared statement
     $stmt = $connection->prepare(
          "INSERT INTO posts (title, body, thumbnail, category_id, author_id, is_featured)
         VALUES (?, ?, ?, ?, ?, ?)"
     );

     $stmt->bind_param("sssiii", $title, $body, $thumbnail_name, $category_id, $author_id, $is_featured);
     $stmt->execute();

     if ($stmt->affected_rows === 1) {
          unset($_SESSION['add-post-data']);
          $_SESSION['add-post-success'] = "Post added successfully.";
          header('Location: ' . ROOT_URL . 'admin/');
          exit;
     } else {
          $_SESSION['add-post-errors'] = ['Database error. Please try again.'];
          header('Location: ' . ROOT_URL . 'admin/add-post.php');
          exit;
     }
} else {
     // If accessed without form submission
     header('Location: ' . ROOT_URL . 'admin/add-post.php');
     exit;
}
