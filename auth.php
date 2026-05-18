<?php
require "config.php";

// If user is NOT logged in, send them back to login page
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>