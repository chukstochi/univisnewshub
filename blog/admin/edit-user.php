<?php
session_start();
require '../config/database.php';
include 'partials/header.php';

// Redirect if user is not logged in
if (!isset($_SESSION['id'])) {
    header('Location: ' . ROOT_URL . 'admin/manage-user.php');
    exit();
}

// Validate user ID from GET
$user_id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$user_id) {
    $_SESSION['edit-user-error'] = "Invalid user ID.";
    header('Location: ' . ROOT_URL . 'admin/manage-user.php');
    exit();
}

// Fetch user from database
$query = "SELECT * FROM users WHERE id = ?";
$stmt = $connection->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if (!$user) {
    $_SESSION['edit-user-error'] = "User not found.";
    header('Location: ' . ROOT_URL . 'admin/manage-user.php');
    exit();
}
?>

<section class="form__section">
    <div class="container form__section-container">
        <!-- Optional: Sidebar toggle buttons -->
        <button id="show_sidebar-btn" class="sidebar_toggle"><i class='bx bx-arrow-right'></i></button>
        <button id="hide_sidebar-btn" class="hidebar_toggle"><i class='bx bx-arrow-left'></i></button>

        <h2>Edit User</h2>

        <?php if (isset($_SESSION['edit-user-error'])): ?>
            <div class="alert__message error">
                <?= htmlspecialchars($_SESSION['edit-user-error']) ?>
                <?php unset($_SESSION['edit-user-error']); ?>
            </div>
        <?php endif; ?>

        <form action="<?= ROOT_URL ?>admin/edit-user-logic.php" method="POST">
            <input type="hidden" name="id" value="<?= htmlspecialchars($user['id']) ?>">

            <input type="text" name="firstname" value="<?= htmlspecialchars($user['firstname']) ?>" placeholder="First Name" required>
            <input type="text" name="lastname" value="<?= htmlspecialchars($user['lastname']) ?>" placeholder="Last Name" required>

            <select name="userrole" required>
                <option value="0" <?= $user['is_admin'] == 0 ? 'selected' : '' ?>>Author</option>
                <option value="1" <?= $user['is_admin'] == 1 ? 'selected' : '' ?>>Admin</option>
            </select>

            <button type="submit" name="submit" class="btn">Update User</button>
        </form>
    </div>
</section>

<?php include 'partials/footer.php'; ?>