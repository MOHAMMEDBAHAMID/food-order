<?php include('partials/menu.php') ?>
<!-- Start Main Content Section -->
<div class="main-content">
    <div class="wrapper">
        <h1>Mange Category</h1>
        <br> <br>

        <?php
        if (isset($_SESSION['add'])) {
            echo $_SESSION['add'];
            unset($_SESSION['add']);
        }

        if (isset($_SESSION['remove'])) {
            echo $_SESSION['remove'];
            unset($_SESSION['remove']);
        }

        if (isset($_SESSION['delete'])) {
            echo $_SESSION['delete'];
            unset($_SESSION['delete']);
        }

        if (isset($_SESSION['cat-update'])) {
            echo $_SESSION['cat-update'];
            unset($_SESSION['cat-update']);
        }

        if (isset($_SESSION['upload'])) {
            echo $_SESSION['upload'];
            unset($_SESSION['upload']);
        }

        if (isset($_SESSION['remove-old-image'])) {
            echo $_SESSION['remove-old-image'];
            unset($_SESSION['remove-old-image']);
        }
        ?>
        <br><br><br>
        <a href="<?php echo SITEURL; ?>admin/add-category.php" class="btn-primary">Add Category</a>
        <br> <br> <br>
        <table class="tbl-full">
            <tr>
                <th>S.N.</th>
                <th>Title</th>
                <th>Image</th>
                <th>Feature</th>
                <th>Active</th>
                <th>Actions</th>
            </tr>

            <?php
            // Query To Get All Data 
            $sql = "SELECT * FROM tbl_category";
            // Execute The Query 
            $res = mysqli_query($conn, $sql);
            // Count Rows
            $count = mysqli_num_rows($res);
            // Create Sn Value
            $sn = 1;

            // Check Whether We Have Data Or Not 
            if ($count > 0) {
                // We Have Data 
                // Get Data From Database
                while ($row = mysqli_fetch_assoc($res)) {
                    $id = $row['id'];
                    $title = $row['title'];
                    $image_name = $row['image_name'];
                    $featured = $row['featured'];
                    $active = $row['active'];

            ?>
                    <tr>
                        <td><?php echo $sn++; ?></td>
                        <td><?php echo $title ?></td>

                        <td>
                            <?php
                            // Check Whether Image Name Available Or Not 
                            if ($image_name != '') {
                                // Display The Image
                            ?>
                                <img src="<?php echo SITEURL; ?>images/category/<?php echo $image_name; ?>" alt="" width="200px">
                            <?php
                            } else {
                                // Display The Message
                                echo '<div class="error"> Image Not Added . </div>';
                            }

                            ?>
                        </td>

                        <td><?php echo $featured ?></td>
                        <td><?php echo $active ?></td>
                        <td>
                            <a href="<?php echo SITEURL; ?>admin/update-category.php ?id=<?php echo $id; ?>" class="btn-secondary">Update Category </a>
                            <a href="<?php echo SITEURL; ?>admin/delete-category.php?id=<?php echo $id; ?> & image_name=<?php echo $image_name; ?>" class="btn-danger">Delete Category </a>
                        </td>

                    </tr>
                <?php
                }
            } else {
                // We Don't Have Data 
                // We Will Display Message 
                ?>
                <tr>
                    <td colspan="6">
                        <div class="error"> No Category Added . </div>
                    </td>
                </tr>

            <?php
            }
            ?>


        </table>
    </div>
    <!-- End Main Content Section -->

    <?php include('partials/footer.php') ?>