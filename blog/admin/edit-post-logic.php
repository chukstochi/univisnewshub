<?php
require 'config/database.php';
session_start();

if (!isset($_POST['submit'])) {
     header('Location: ' . ROOT_URL . 'admin/');
     exit();
}

// Get and validate input
$post_id     = filter_var($_POST['id'], FILTER_VALIDATE_INT);
$title       = trim($_POST['title'] ?? '');
$body        = trim($_POST['body'] ?? '');
$category_id = filter_var($_POST['category'], FILTER_VALIDATE_INT);
$is_featured = isset($_POST['is_featured']) ? 1 : 0;
$author_id   = $_SESSION['user-id'] ?? null;
$thumbnail   = $_FILES['thumbnail'] ?? null;

// Preserve form data in session for re-use if errors occur
$_SESSION['edit-post-data'] = [
     'title'    => $title,
     'body'     => $body,
     'category' => $category_id
];

// Validate required fields
$errors = [];

if (!$post_id)        $errors[] = "Invalid post ID.";
if (!$title)          $errors[] = "Post title is required.";
if (!$body)           $errors[] = "Post body is required.";
if (!$category_id)    $errors[] = "Please select a category.";
if (!$author_id)      $errors[] = "You must be logged in to edit a post.";

// If validation fails, redirect back
if (!empty($errors)) {
     $_SESSION['edit-post-errors'] = $errors;
     header("Location: " . ROOT_URL . "admin/edit-post.php?id=$post_id");
     exit();
}

// Check if new thumbnail is uploaded
$thumbnail_name = null;
if ($thumbnail && $thumbnail['error'] === 0) {
     $allowed_types = ['image/png', 'image/jpeg', 'image/jpg', 'image/webp'];

     if (!in_array($thumbnail['type'], $allowed_types)) {
          $_SESSION['edit-post-errors'] = ['Thumbnail must be an image file (PNG, JPG, JPEG, or WEBP).'];
          header("Location: " . ROOT_URL . "admin/edit-post.php?id=$post_id");
          exit();
     }

     $thumbnail_name = time() . '-' . basename($thumbnail['name']);
     $thumbnail_path = '../images/' . $thumbnail_name;

     if (!move_uploaded_file($thumbnail['tmp_name'], $thumbnail_path)) {
          $_SESSION['edit-post-errors'] = ['Failed to upload new thumbnail.'];
          header("Location: " . ROOT_URL . "admin/edit-post.php?id=$post_id");
          exit();
     }

     // Optional: delete old thumbnail here if stored (requires query to fetch it)
}

// If featured, un-feature other posts
if ($is_featured === 1) {
     $connection->query("UPDATE posts SET is_featured = 0");
}

// Build update query dynamically
$update_query = "UPDATE posts SET title = ?, body = ?, category_id = ?, is_featured = ?";
$params = [$title, $body, $category_id, $is_featured];
$types = "ssii";

if ($thumbnail_name) {
     $update_query .= ", thumbnail = ?";
     $params[] = $thumbnail_name;
     $types .= "s";
}

$update_query .= " WHERE id = ?";
$params[] = $post_id;
$types .= "i";

// Execute query
$stmt = $connection->prepare($update_query);
$stmt->bind_param($types, ...$params);
$stmt->execute();

if ($stmt->affected_rows >= 0) {
     unset($_SESSION['edit-post-data']);
     $_SESSION['edit-post-success'] = "Post updated successfully.";
     header('Location: ' . ROOT_URL . 'admin/');
     exit();
} else {
     $_SESSION['edit-post-errors'] = ['Failed to update post. Please try again.'];
     header("Location: " . ROOT_URL . "admin/edit-post.php?id=$post_id");
     exit();
}
