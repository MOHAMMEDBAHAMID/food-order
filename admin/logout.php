<?php
// Include Constants
include('../config/constants.php');

// 1.Destroy The Sesstion
session_destroy();

// 2.Redirect To Login Page
header('location:'.SITEURL.'admin/login.php');
?>