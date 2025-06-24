<?php
require 'partials/header.php';
// require 'config/constant.php';
$token = $_GET['token'] ?? '';
?>

<!DOCTYPE html>
<html>

<head>
     <title>Reset Password</title>
     <link rel="stylesheet" href="./css/styles.css">
</head>

<body>
     <section class="form__section">
          <div class="container form__section-container">
               <h2>Enter New Password</h2>
               <form action="reset-password-logic.php" method="POST">
                    <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">
                    <input type="password" name="new_password" placeholder="New Password" required>
                    <input type="password" name="confirm_password" placeholder="Confirm Password" required>
                    <button type="submit" name="reset-password" class="btn">Reset Password</button>
               </form>
          </div>
     </section>
</body>

</html>