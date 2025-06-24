<?php
require 'config/constant.php';
// destroy all session and redirect users to login page
session_destroy();
header('location: ' . ROOT_URL);
die();
