<?php
require '../config/database.php';

if (isset($_POST['submit'])) {
    $id = filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);
    $firstname = filter_var($_POST['firstname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $lastname = filter_var($_POST['lastname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $userrole = filter_var($_POST['userrole'], FILTER_SANITIZE_NUMBER_INT);

    if (!$firstname || !$lastname || !isset($userrole)) {
        $_SESSION['edit-user-error'] = "Please fill in all fields correctly.";
        header("Location: " . ROOT_URL . "admin/edit-user.php?id=$id");
        exit();
    }

    $query = "UPDATE users SET firstname = ?, lastname = ?, is_admin = ? WHERE id = ?";
    $stmt = $connection->prepare($query);

    if (!$stmt) {
        $_SESSION['edit-user-error'] = "Database error: " . $connection->error;
        header("Location: " . ROOT_URL . "admin/edit-user.php?id=$id");
        exit();
    }

    $stmt->bind_param("ssii", $firstname, $lastname, $userrole, $id);

    if ($stmt->execute()) {
        $_SESSION['edit-user-success'] = "User updated successfully.";
    } else {
        $_SESSION['edit-user-error'] = "Update failed: " . $stmt->error;
    }

    header('Location: ' . ROOT_URL . 'admin/manage-user.php');
    exit();
} else {
    header('Location: ' . ROOT_URL . 'admin/manage-user.php');
    exit();
}