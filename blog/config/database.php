<?php
require 'config/constant.php';

// Connect to database
$connection = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if (mysqli_errno($connection)) {
     die(mysqli_error($connection));
}
