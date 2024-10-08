<?php
// Include Constants File
include('../config/constants.php');

if (isset($_GET['id']) && isset($_GET['image_name'])) {
    // Proccess To Delete

    // 1.Get Id And Image Name 
    $id = $_GET['id'];
    $image_name = $_GET['image_name'];

    // 2.Remove The Image If Available 
    // 2.1.Cheack Whether Image Is Available Or Not
    if($image_name !=''){
        // Means It Has Image
        $path = '../images/food/'.$image_name;
        // Remove The Image
        $remove = unlink($path);

        // Check Whether We Romve The Image Or Not 
        if($remove == false){
            // Means Failed To Remove The Image 
            $_SESSION['imag-remove'] = '<div class="error">Failed To Remove The Image . </div>';
            // Redirect To Manage Food Page 
            header('location:'.SITEURL.'admin/manage-food.php');
            // Stop The Proccess
            die();
        }

    }else{
        // There Is NO Image
    }

    // 3.Delete Food From Database
    // 3.1.Create Query To Delete The Food
    $sql = "DELETE FROM tbl_food WHERE id=$id";
    // Execute THe Query
    $res = mysqli_query($conn,$sql);
    // 3.2.Check Whether Query Executed Or Not And Redirect With Session Message
    if($res == true){
        // Means Query Exected Successfully
        $_SESSION['delete'] = '<div class="success">Food Deleted Successfully . </div>';
        header('location:'.SITEURL.'admin/manage-food.php');
    }else{
        // Failed To Delete Th Food 
        $_SESSION['delete'] = '<div class="error">Failed To Delete The Food . </div>';
        header('location:'.SITEURL.'admin/manage-food.php');

    }

} else {
    // Redirect To Manage Food Page And Set Message
    $_SESSION['unauthorize'] = '<div class="error">Unauthorized Access . </div>';
    header('location:' . SITEURL . 'admin/manage-food.php');
}
