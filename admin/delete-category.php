<?php
//  include Constants File 
include('../config/constants.php');

// Check Whether Th Id And Name Image Value Is Set Or Not 
if (isset($_GET['id']) and isset($_GET['image_name'])) {
    // Get The Value And Delete 
    $id = $_GET['id'];
    $image_name = $_GET['image_name'];

    // Remove The Physical Image File If Available
    if ($image_name != '') {
        // Image Available . So Remove It
        $path = '../images/category/' . $image_name;
        // Rmove The Image
        $remove = unlink($path);
        // If Failed TO Remove Add Error Message
        if ($remove == false) {
            // Set Session Message
            $_SESSION['remove-old-image'] = "<div class=''error> Failed To Remove The Old Image . </div>";
            // Redirect To Manage Category 
            header("location:" . SITEURL . "admin/manage-category.php");
            // Stop The Process
            die();
        }
    }

    // Delete The Data From Database
    // Sql Query To Delete The Data
    $sql = "DELETE FROM tbl_category WHERE id = $id";
    // Execute The Query
    $res = mysqli_query($conn, $sql);

    // Check Whether Data Is Deleted Or Not
    if ($res == true) {
        // Set Session 
        $_SESSION['delete'] = "<div class='success'>Category Deleted Successfully . </div>";
        // Redirect To Mange Category Page
        header('location:' . SITEURL . 'admin/manage-category.php');
    } else {
        // Set Session 
        $_SESSION['delete'] = "<div class='error'>FAiled To Delete The Category . </div>";
        // Redirect To Mange Category Page
        header('location:' . SITEURL . 'admin/manage-category.php');
    }
} else {
    // Redirect TO Manage Category Page
    header('location:' . SITEURL . 'admin/manage-category.php');
}
