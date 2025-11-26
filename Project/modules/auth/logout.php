<?php
// modules/auth/logout.php - Logout

session_start();
session_destroy();

header('location: ../../index.php?page=home');
exit;
?>