<!-- ?php require 'config/constant.php'; ?> -->
<?php
require 'partials/header.php'

?>
<!DOCTYPE html>
<html>

<head>
     <title>Forgot Password</title>
     <!-- <link rel="stylesheet" href="./css/styles.css"> -->
</head>

<body>
     <section class="form__section">
          <div class="container form__section-container">
               <h2>Reset Your Password</h2>
               <form action="reset-password-request.php" method="POST">
                    <input type="email" name="email" placeholder="Enter your email" required>
                    <button type="submit" name="reset-request" class="btn">Send Reset Link</button>
                    <small>Back to <a href="signin.php">Sign In</a></small>
               </form>
          </div>
     </section>
</body>

</html>