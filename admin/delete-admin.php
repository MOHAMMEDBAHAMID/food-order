<?php
// Include Constants File
include('../config/constants.php');

// 1.Get The Id Of Admin To Be Deleted
$id = $_GET['id'];
// 2.Create Sql Query To Delete Admin
$sql = "DELETE FROM tbl_admin WHERE id=$id";
// 3.Executing The Query 
$res = mysqli_query($conn, $sql);

// Check If The Query Excuted Or Not 
if ($res == true) {
    // Query Executed Seccessfully
    $_SESSION['delete'] = '<div class="deleted">Admin Deleted Successfully</div>';
    // Redirect To Manage Admin Page
    header('location:' . SITEURL . 'admin/manage-admin.php');
} else {
    // Failed To Delete Admin
    $_SESSION['delete'] = "Failed To Delete Admin Please Try Again Later";
    // Redirect To Manage Admin Page
    header('location:' . SITEURL . 'admin/manage-admin.php');
}
