<?php include('partials/menu.php'); ?>
<?php
// Check Whether Id Is Set Or Not 
if (isset($_GET['id'])) {
    // Get All Details
    $id = $_GET['id'];

    // Query To Get All The Details
    $sql2 = "SELECT * FROM tbl_food WHERE id = $id";
    // Execute The Query
    $res2 = mysqli_query($conn, $sql2);

    // Get The Values Based On Query Executed 
    $row2 = mysqli_fetch_assoc($res2);
    // Get The Individual Values Of Selected Food
    $title = $row2['title'];
    $description = $row2['description'];
    $price = $row2['price'];
    $current_image = $row2['image_name'];
    $current_category = $row2['category_id'];
    $featured = $row2['featured'];
    $active = $row2['active'];
} else {
    // Redirect To Manage Food Page
    header('location:' . SITEURL . 'admin/manage-food.php');
}

?>

<div class="main-content">
    <div class="wrapper">
        <h1>Update Food</h1>
        <br> <br>



        <!-- Start Update Food Form -->
        <form action="" method="post" enctype="multipart/form-data">
            <table class="tbl-30">
                <tr>
                    <td>Title:</td>
                    <td>
                        <input type="text" name="title" value="<?php echo $title; ?>">
                    </td>
                </tr>

                <tr>
                    <td>Descriptin:</td>
                    <td>
                        <textarea name="description" cols="30" rows="5"><?php echo $description; ?></textarea>
                    </td>
                </tr>

                <tr>
                    <td>Price:</td>
                    <td>
                        <input type="number" name="price" value="<?php echo $price; ?>">
                    </td>
                </tr>

                <tr>
                    <td>
                        Current Image
                    </td>

                    <td>

                        <?php
                        // Check Whether Image Available Or Not
                        if ($current_image == "") {
                            // Image Is Not Available
                            echo '<div class="error">Image Not Available . </div>';
                        } else {
                            // Image Is Available And Display Current Image
                        ?>

                            <img src="<?php echo SITEURL; ?>images/food/<?php echo $current_image; ?>" alt="" width="150px">
                        <?php
                        }

                        ?>
                    </td>
                </tr>

                <tr>
                    <td>Select New Image:</td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>

                <tr>
                    <td>Category:</td>
                    <td>
                        <select name="category">
                            <?php
                            // Query To Get Active Categories 
                            $sql = "SELECT * FROM tbl_category WHERE active ='YES'";
                            // Execute The Query
                            $res = mysqli_query($conn, $sql);
                            // Count The Rows
                            $count = mysqli_num_rows($res);

                            // Check Whether Categories Available Or Not
                            if ($count > 0) {
                                // Categories Available
                                while ($row = mysqli_fetch_assoc($res)) {
                                    $category_id = $row['id'];
                                    $category_title = $row['title'];

                            ?>

                                    <option <?php if ($current_category == $category_id) {
                                                echo 'selected';
                                            } ?> value="<?php echo $category_id; ?>"><?php echo $category_title; ?></option>

                            <?php
                                }
                            } else {
                                // Categories Not Available

                                echo '<option value="0">Category Not Available . </option>';
                            }

                            ?>


                        </select>
                    </td>
                </tr>

                <tr>
                    <td>Featured:</td>
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
                    <td>Active:</td>
                    <td>
                        <input <?php if ($active == 'Yes') {
                                    echo 'checked';
                                } ?> type="radio" name="active" value="Yes">Yes
                        <input <?php if ($active == 'No') {
                                    echo 'checked';
                                } ?> type="radio" name="active" value="No">No
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">
                        <input type="submit" name="submit" class="btn-secondary" value="Update Food">
                    </td>
                </tr>

            </table>
        </form>
        <!-- End Update Food Form -->
    </div>

</div>
<?php
if (isset($_POST['submit'])) {

    // 1.Get All Data From The From
    $id = $_POST['id'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $new_image = $_FILES['image']['name'];
    $current_image = $_POST['current_image'];
    $category_id = $_POST['category'];
    $featured = $_POST['featured'];
    $active = $_POST['active'];
    $image_name;

    if ($new_image != '') {
        // Means Uploaded A new Image
        // 1.Rename And Upload The New Image
        // A. Get The Extension Of Selected Image (jpg,png,..etc)
        $image_name = $new_image;
        $image_name_part = explode('.', $image_name);
        $ext = end($image_name_part);

        $image_name = "Food_Name" . rand(000, 999) . '.' . $ext; // e.g Food_Category.jpg

        // B. Upload The Image
        $source_path = $_FILES['image']['tmp_name'];

        $destination_path = "../images/food/" . $image_name;

        // Finally Upload The Image 
        $upload = move_uploaded_file($source_path, $destination_path);

        // Check Whether The Image Is Uploaded Or Not 
        // And If The Image Is Not Uploaded We Will Stop The Process ANd Redirect With Error Message
        if ($upload == FALSE) {
            // Set Message
            $_SESSION['upload'] = '<div class="error"> Failed To Upload The Image . </div>';
            // Redirect To Add Category Page
            header('location:' . SITEURL . 'admin/add-food.php');
            // Stop The Process
            die();
        }

        // 2.Remove The Current Image If Is Available
        if ($current_image != '') {

            $remove_path = "../images/food/" . $current_image;
            $remove = unlink($remove_path);

            // Check Whether Image Removed Or Not 
            if ($remove == false) {
                // Failed To Remove The Image
                $_SESSION['remove-faild'] = '<div class="error">Faild To Remove Current Image . </div>';
                header('location:' . SITEURL . 'admin/manage-food.php');
                // Stop The Process
                die();
            }
        }
    } else {
        // There Is No New Image Uploaded
        $image_name = $current_image;
    }


    // 3.Update The Data In Our Database
    // 3.1.Create The Query To Update 
    $sql3 = "UPDATE tbl_food SET
            title = '$title',
            description = '$description',
            price = $price,
            image_name = '$image_name',
            category_id = '$category_id',
            featured = '$featured',
            active = '$active'
            WHERE id = $id
        ";
    // 3.2.Execute The Query 
    $res3 = mysqli_query($conn, $sql3);

    // Check Whether Queru Executed Or Not
    if ($res3 == true) {
        $_SESSION['update'] = '<div class="success">Food Update Successfully . </div>';
        // header('location:' . SITEURL . 'admin/manage-food.php');
        echo'<script> window.location.href="manage-food.php"</script>';
    } else {

        $_SESSION['update'] = '<div class="success">Failed To Update Food  . </div>';
        // header('location:' . SITEURL . 'admin/manage-food.php');
        echo'<script> window.location.href="manage-food.php"</script>';
    }
}

?>


<?php include('partials/footer.php');
