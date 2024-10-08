<?php

    // Authorization - Access Control 
    // Check Whether The User Is Logged In Or Not 
    if(!isset($_SESSION['user']))//If User Session Not Set
    {
        // User Is Not Logged In
        // Redirect To Login Page With Message
        $_SESSION['no-login-message'] = "<div class='error text-center'>Please Login To Access Admin Panel</div>";
        header('location:' .SITEURL.'admin/login.php');
    } 
?>
