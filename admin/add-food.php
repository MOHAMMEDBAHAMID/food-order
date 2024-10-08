<?php include('partials/menu.php') ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Food</h1>
        <br> <br>

        <?php

        if(isset($_SESSION['upload'])){
            echo $_SESSION['upload'];
            unset($_SESSION['upload']);
        }


        ?>

        <!-- Start Add Food Form -->
        <form action="" method="post" enctype="multipart/form-data">
            <table class="tbl-30">
                <tr>
                    <td>Title:</td>
                    <td>
                        <input type="text" name="title" placeholder="Enter The Title Of Food">
                    </td>
                </tr>

                <tr>
                    <td>Descriptin:</td>
                    <td>
                        <textarea name="description" cols="30" rows="5" placeholder="Enter The Descripton Of Food"></textarea>
                    </td>
                </tr>

                <tr>
                    <td>Price:</td>
                    <td>
                        <input type="number" name="price">
                    </td>
                </tr>

                <tr>
                    <td>Select Image:</td>
                    <td>
                        <input type="file" name="image" >
                    </td>
                </tr>

                <tr>
                    <td>Category:</td>
                    <td>
                        <select name="category">

                            <?php
                            // PHP Code To Diplay Categories From Database
                            // 1. Create Query To Get All Active Categories From Database
                            $sql = "SELECT * FROM tbl_category WHERE active = 'Yes'";
                            // 1.1.Execute The Query
                            $res = mysqli_query($conn, $sql);

                            // 1.2.Count The Rows To Check Whether We Have Data Or Not
                            $count = mysqli_num_rows($res);

                            //If Count > 0 Means We Have Category
                            if ($count > 0) {
                                // We Hava Category 

                                while ($row = mysqli_fetch_assoc($res)) {
                                    // 1.3.Get The Details Of Categories 
                                    $id = $row['id'];
                                    $title = $row['title'];

                                    echo "<option value='$id'> $title</option>";

                                }
                            } else {
                                // We Don't Have Category 
                                ?>

                                <option value="0">No Category Found . </option>
                            <?php

                            }


                            ?>


                        </select>
                    </td>
                </tr>

                <tr>
                    <td>Featured:</td>
                    <td>
                        <input type="radio" name="featured" value="Yes">Yes
                        <input type="radio" name="featured" value="No">No
                    </td>
                </tr>

                <tr>
                    <td>Active:</td>
                    <td>
                        <input type="radio" name="active" value="Yes">Yes
                        <input type="radio" name="active" value="No">No
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" class="btn-secondary" value="Add Food">
                    </td>
                </tr>
            </table>
        </form>
        <!-- End Add Food Form -->

        <?php
        // Check Whether Submit Button Clicked Or Not
        if (isset($_POST['submit'])) {
            // Add The Food Into Our Database

            // 1.Get The Data From The Form
            $title = $_POST['title'];
            $description = $_POST['description'];
            $price = $_POST['price'];
            $category = $_POST['category'];

            // 1.1.Check Whether Featured And Active Seleceted Or Not And Set Default 
            if (isset($_POST['featured'])) {
                $featured = $_POST['featured'];
            } else {
                // Setting Default Value
                $featured = "NO";
            }
            if (isset($_POST['active'])) {
                $active = $_POST['active'];
            } else {
                // Setting Default Value
                $active = "NO";
            }

            // 2.Upload The Image If Selected
            // 2.1.Check Whether Image Selected Or Not And UPload The Image If is Selected 

            if ($_FILES['image']['name']) {
                //Get The Details Of The Selected Image 
                $image_name = $_FILES['image']['name'];

                // Check Whether Image Selected Or Not
                if ($image_name != '') {
                    // Means Image Selected 
                    // A.Rename The Image 
                    // Get The Extension Of Selected Image (jpg,png,..etc)
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
                }
            } else {
                // Means Image Not Selected And Will Be Empty As A Default Value
                $image_name = "";
            }


            // 3.Insert Into Databsase
            // 3.1.Create The Query To Insert The Data 
            $sql2 = "INSERT INTO tbl_food SET
                title = '$title',
                description = '$description',
                price = $price,
                image_name = '$image_name',
                category_id = $category,
                featured = '$featured',
                active = '$active'
            ";
            // 3.2.Execute The Query
            $res2 = mysqli_query($conn,$sql2);
            // 4. Check Whether Query Executed Or Not And Redirect With Message to Manage Food Page

            if($res2 == TRUE){
                // Data Inserted Successfully
                $_SESSION['add'] = '<div class="success">Food Added Successfully . </div>';
                header('location:'.SITEURL.'admin/manage-food.php');
                
            }else{
                //Failed To Inser Data 
                $_SESSION['add'] = '<div class="error">Failed To Add Food . </div>';
                header('location:'.SITEURL.'admin/manage-food.php');

            }

            
        }

        ?>
    </div>
</div>



<?php include('partials/footer.php') ?>