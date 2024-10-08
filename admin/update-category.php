<?php include('partials/menu.php') ?>

<?php
if (isset($_GET['id'])) {

    // Get Th Id Of Category
    $id = $_GET['id'];

    // Create Sql Query To Get Remainder Data
    $sql = "SELECT * FROM tbl_category WHERE id = $id ";
    // Execute The Query 
    $res = mysqli_query($conn, $sql);

    // Check Whether Query Executed Or Not
    if ($res == TRUE) {
        // Query Executed
        // Count The Rows To Check Whetther The Id Is Available Or Not
        $count = mysqli_num_rows($res);

        if ($count == 1) {
            // Id Available
            $row = mysqli_fetch_assoc($res);
            $id = $row['id'];
            $title = $row['title'];
            $current_image = $row['image_name'];
            $featured = $row['featured'];
            $active = $row['active'];
        } else {
            // Id Not Available
            // Redirect To Manage Category Page
            header('location:' . SITEURL . 'admin/manage-category.php');
        }
    } else {
        // Query Did Not Execute
        echo 'Query Did Not Execute';
    }
} else {
    // Redirect To Manage Category Page
    header('location:' . SITEURL . 'admin/manage-category.php');
}
?>
<div class="main-content">
    <div class="wrapper">
        <h1>Update Category</h1>

        <br><br>
        <!-- Update Category Form Starts -->

        <form action="" method="post" enctype="multipart/form-data">
            <table class="tbl-30">
                <tr>
                    <td>Title : </td>
                    <td>
                        <input type="text" name="title" value="<?php echo $title ?>">
                    </td>
                </tr>

                <tr>
                    <td>Current Image :</td>
                    <td>
                        <?php
                        if ($current_image != '') {
                            // Image Will Display 
                        ?>
                            <img src="<?php echo SITEURL; ?>images/category/<?php echo $current_image; ?>" alt="" width="200px">
                        <?php
                        } else {
                            // Display Error Message Image Not Added
                            echo "<div class='error'>Image Don't Added . </div>";
                        }
                        ?>

                    </td>
                </tr>

                <tr>
                    <td>New Image : </td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>

                <tr>
                    <td>Featured : </td>
                    <td>
                        <input <?php if ($featured == 'Yes') {
                                    echo "checked";
                                } ?> type="radio" name="featured" value="Yes">Yes
                        <input <?php if ($featured == 'No') {
                                    echo "checked";
                                } ?> type="radio" name="featured" value="No">No
                    </td>

                </tr>

                <tr>
                    <td>Active : </td>
                    <td>
                        <input <?php if ($active == 'Yes') {
                                    echo "checked";
                                } ?> type="radio" name="active" value="Yes">Yes
                        <input <?php if ($active == 'No') {
                                    echo "checked";
                                } ?> type="radio" name="active" value="No">No
                    </td>

                </tr>

                <tr>
                    <td>
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">
                        <input type="submit" name="submit" value="Update Category" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>
        <!-- Update Category Form Ends   -->
    </div>
</div>

<?php



if (isset($_POST['submit'])) {
    // If Submit Button Clicked Get The Data From The Form
    $id = $_POST['id'];
    $title = $_POST['title'];
    $new_image_name = $_FILES['image']['name'];
    $current_image = $_POST['current_image'];
    $featured = $_POST['featured'];
    $active = $_POST['active'];
    $image_name;
    // Check Whether Image Changed Or Not 
    if ($new_image_name != '') {
        // Image Changed

        // A.Add The Image To Our File
        // Auto Rename Our Image
        // Get The Extention Of Our Image (jpg,png,..etc) 
        $image_name = $new_image_name;
        $image_name_part = explode('.', $image_name);
        $ext = end($image_name_part);
        // Rename The Image 
        $image_name = "Food_Category" . rand(000, 999) . '.' . $ext; // e.g Food_Category.jpg

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
            header('location:' . SITEURL . 'admin/manage-category.php');
            // Stop The Process
            die();
        }

        // B. Remove The Current Image If Is Avaailable
        if($current_image !=''){

            $remove_path = '../images/category/' . $current_image;
            $remove = unlink($remove_path);
            // If Failed TO Remove Add Error Message
            if ($remove == false) {
                // Set Session Message
                $_SESSION['remove'] = "<div class=''error> Failed To Remove The Image . </div>";
                // Redirect To Manage Category 
                header("location:" . SITEURL . "admin/manage-category.php");
                // Stop The Process
                die();
            }
        } 
    } else {
        // Image Didn't Change And Still The Same
        $image_name = $current_image;
    }


    $sql2 = "UPDATE tbl_category SET
    title = '$title',
    image_name = '$image_name',
    featured = '$featured',
    active = '$active'
    WHERE id = $id
     ";

    // Execute The Query 
    $res2 = mysqli_query($conn, $sql2);

    if ($res2 == TRUE) {
        // Means Query Executed, Set Session Success Message 
        $_SESSION['cat-update'] = '<div class="success">Category Uploadde Successfully . </div>';
        // Redirect To Manage Category Page
        header('location:' . SITEURL . 'admin/manage-category.php');
    } else {

        // Means Query Did Not Execute, Set Error Session Message 
        $_SESSION['cat-update'] = '<div class="error">Failed To Upload Category . </div>';
        // Redirect To Manage Category Page
        header('location:' . SITEURL . 'admin/manage-category.php');
    }
}


?>




<?php include('partials/footer.php') ?>