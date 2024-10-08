<?php include('partials/menu.php'); ?>
<div class="main-content">
    <div class="wrapper">
        <h1>Add Category</h1>

        <br><br>

        <?php
        if (isset($_SESSION['upload']))
            echo $_SESSION['upload'];
        unset($_SESSION['upload']);
        ?>
        <!-- Add Category Form Starts -->
        <form action="" method="post" enctype="multipart/form-data">
            <table class="tbl-30">
                <tr>
                    <td>Title : </td>
                    <td>
                        <input type="text" name="title" placeholder="Category Title">
                    </td>
                </tr>

                <tr>
                    <td>Select Image : </td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>

                <tr>
                    <td>Featured : </td>
                    <td>
                        <input type="radio" name="featured" value="Yes">Yes
                        <input type="radio" name="featured" value="No">No
                    </td>

                </tr>

                <tr>
                    <td>Active : </td>
                    <td>
                        <input type="radio" name="active" value="Yes">Yes
                        <input type="radio" name="active" value="No">No
                    </td>

                </tr>

                <tr>
                    <td>
                        <input type="submit" name="submit" value="Add Category" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>
        <!-- Add Category Form Ends -->
    </div>
</div>

<?php

// Check Whether Submit Clicked Or Not 
if (isset($_POST['submit'])) {
    // 1.Get Data From Form
    $title = $_POST['title'];
    // For Radio Input
    if (isset($_POST['featured'])) {
        // Get The Value From The Form
        $featured = $_POST['featured'];
    } else {
        // Set Default Value
        $featured = "No";
    }

    if (isset($_POST['active'])) {
        $active = $_POST['active'];
    } else {
        //Set Default Value
        $active = 'No';
    }

    // Check Whether The Image Is Selected Or Not And Set The Value for image
    if (isset($_FILES['image']['name'])) { // Means We Have Image Uploaded
        // Upload The Image
        // To UPload Image We Need Image Name , Source Path And Destination

        $image_name = $_FILES['image']['name'];

        // UPload The Image Only If Image Selected
        if($image_name !=''){

        
        
        // Auto Rename Our Image
        // Get The Extention Of Our Image (jpg,png,..etc) 
        $image_name_part = explode('.' , $image_name);
        $ext = end($image_name_part);
        // Rename The Image 
        $image_name = "Food_Category".rand(000,999).'.'.$ext ; // e.g Food_Category.jpg

        $source_path = $_FILES['image']['tmp_name'];

        $destination_path = "../images/category/" . $image_name;

        // Finally Upload The Image 
        $upload = move_uploaded_file($source_path, $destination_path);

        // Check Whether The Image Is Uploaded Or Not 
        // And If The Image Is Not Uploaded We Will Stop The Process ANd Redirect With Error Message
        if ($upload == FALSE) {
            // Set Message
            $_SESSION['upload'] = '<div class="error"> Failed To Upload The Image . </div>';
            // Redirect To Add Category Page
            header('location:' . SITEURL . 'admin/add-category.php');
            // Stop The Process
            die();
        }
    }
    } else {
        // Don't Upload The Image And set The Image_name Value Blank
        $image_name = '';
    }
    // 2.Create Sql Query To Insert Category Into Database
    $sql = "INSERT INTO tbl_category SET
            title = '$title',
            image_name = '$image_name',
            featured = '$featured',
            active = '$active'
        ";

    // 3.Execute The Query 
    $res = mysqli_query($conn, $sql);

    // 4.Check Whether Sql Query Executed Or Not 
    if ($res == true) {
        // Query Executed An Added Category 
        $_SESSION['add'] = '<div class="success"> Category Added Successfully . </div>';
        // Redirec To Manage Category Page
        header('location:' . SITEURL . 'admin/manage-category.php');
    } else {
        // Failed 
        $_SESSION['add'] = '<div class="error"> Failed To Add Category . </div>';
        // Redirec To Manage Category Page
        header('location:' . SITEURL . 'admin/manage-category.php');
    }
}

?>
<?php include('partials/footer.php'); ?>