<?php
require 'config/database.php';
session_start(); // Required for using $_SESSION

// Make sure ROOT_URL is defined
if (!defined('ROOT_URL')) {
    define('ROOT_URL', '/'); // Adjust to your actual root URL if needed
}

// Validate post ID from GET
if (!isset($_GET['id']) || !filter_var($_GET['id'], FILTER_VALIDATE_INT)) {
    $_SESSION['delete-post-error'] = "Invalid post ID.";
    header('Location: ' . ROOT_URL . 'admin/');
    exit();
}

$post_id = (int) $_GET['id'];

// Fetch post to get the thumbnail filename
$stmt = $connection->prepare("SELECT thumbnail FROM posts WHERE id = ? LIMIT 1");
if (!$stmt) {
    $_SESSION['delete-post-error'] = "Database error: failed to prepare post check.";
    header('Location: ' . ROOT_URL . 'admin/');
    exit();
}
$stmt->bind_param("i", $post_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows !== 1) {
    $_SESSION['delete-post-error'] = "Post not found.";
    header('Location: ' . ROOT_URL . 'admin/');
    exit();
}

$post = $result->fetch_assoc();
$thumbnail_path = '../images/' . $post['thumbnail'];

// Delete the thumbnail image file
if (file_exists($thumbnail_path) && is_file($thumbnail_path)) {
    unlink($thumbnail_path);
}

// Delete post from the database
$delete_stmt = $connection->prepare("DELETE FROM posts WHERE id = ? LIMIT 1");
if (!$delete_stmt) {
    $_SESSION['delete-post-error'] = "Database error: failed to prepare delete.";
    header('Location: ' . ROOT_URL . 'admin/');
    exit();
}
$delete_stmt->bind_param("i", $post_id);
$delete_stmt->execute();

// Confirm deletion
if ($delete_stmt->affected_rows === 1) {
    $_SESSION['delete-post-success'] = "Post deleted successfully.";
} else {
    $_SESSION['delete-post-error'] = "Failed to delete the post.";
}

// Redirect back to admin dashboard
header('Location: ' . ROOT_URL . 'admin/');
exit();