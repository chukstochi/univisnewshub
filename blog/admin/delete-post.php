<?php
require 'config/database.php';
// session_start();

if (!isset($_GET['id']) || !filter_var($_GET['id'], FILTER_VALIDATE_INT)) {
     $_SESSION['delete-post-error'] = "Invalid post ID.";
     header('Location: ' . ROOT_URL . 'admin/');
     exit();
}

$post_id = (int) $_GET['id'];

// Fetch post to get the thumbnail name
$stmt = $connection->prepare("SELECT thumbnail FROM posts WHERE id = ? LIMIT 1");
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

// Delete thumbnail file if it exists
if (file_exists($thumbnail_path)) {
     unlink($thumbnail_path);
}

// Delete the post from the database
$delete_stmt = $connection->prepare("DELETE FROM posts WHERE id = ? LIMIT 1");
$delete_stmt->bind_param("i", $post_id);
$delete_stmt->execute();

if ($delete_stmt->affected_rows === 1) {
     $_SESSION['delete-post-success'] = "Post deleted successfully.";
} else {
     $_SESSION['delete-post-error'] = "Failed to delete the post.";
}

header('Location: ' . ROOT_URL . 'admin/');
exit();
