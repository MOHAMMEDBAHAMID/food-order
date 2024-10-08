<?php include('partials/menu.php'); ?>
<!-- Start Main Content Section -->
<div class="main-content">
    <div class="wrapper">
        <h1>Mange Food</h1>
        <br> <br>
        <?php
        if (isset($_SESSION['add'])) {
            echo $_SESSION['add'];
            unset($_SESSION['add']);
        }

        if (isset($_SESSION['delete'])) {
            echo $_SESSION['delete'];
            unset($_SESSION['delete']);
        }

        if (isset($_SESSION['unauthorize'])) {
            echo $_SESSION['unauthorize'];
            unset($_SESSION['unauthorize']);
        }

        if (isset($_SESSION['imag-remove'])) {
            echo $_SESSION['imag-remove'];
            unset($_SESSION['imag-remove']);
        }

        if (isset($_SESSION['remove-faild'])) {
            echo $_SESSION['remove-faild'];
            unset($_SESSION['remove-faild']);
        }

        if (isset($_SESSION['update'])) {
            echo  $_SESSION['update'];
            unset($_SESSION['update']);
        }


        ?>

        <br><br>

        <a href="<?php echo SITEURL ?>admin/add-food.php" class="btn-primary">Add Food</a>
        <br> <br> <br>
        <table class="tbl-full">
            <tr>
                <th>S.N.</th>
                <th>Title</th>
                <th>Price</th>
                <th>Image</th>
                <th>Featured</th>
                <th>Active</th>
                <th>Actions</th>
            </tr>

            <?php
            // Create The Query To Get The Data From Our Database
            $sql = "SELECT * FROM tbl_food";
            // Execute The Query
            $res = mysqli_query($conn, $sql);
            // Count To Check Whether We Have Data Or Not
            $count = mysqli_num_rows($res);
            $sn = 1;

            if ($count > 0) {
                // Means We Have Data To Display
                while ($row = mysqli_fetch_assoc($res)) {
                    $id = $row['id'];
                    $title = $row['title'];
                    $price = $row['price'];
                    $image_name = $row['image_name'];
                    $featured = $row['featured'];
                    $active = $row['active'];
            ?>
                    <tr>
                        <td><?php echo $sn++; ?></td>
                        <td><?php echo $title; ?></td>
                        <td><?php echo $price ?></td>
                        <td>
                            <?php
                            // Check Wether We Have Image Or Not
                            if ($image_name != '') {
                            ?>

                                <img src="../images/food/<?php echo $image_name ?> " alt="" width="200px">
                            <?php

                            } else {
                                // Image Not Added
                                echo '<div class="error">Image Not Added . </div>';
                            }
                            ?>
                        </td>
                        <td><?php echo $featured; ?></td>
                        <td><?php echo $active; ?></td>
                        <td>
                            <a href="<?php echo SITEURL; ?>admin/update-food.php?id=<?php echo $id; ?>" class="btn-secondary">Update Food</a>
                            <a href="<?php echo SITEURL; ?>admin/delete-food.php?id=<?php echo $id; ?>&image_name=<?php echo $image_name; ?>" class="btn-danger">Delete Food</a>

                        </td>


                    </tr>
                <?php
                }
            } else {
                ?>
                <!--  Means We Don't Have Data To Display -->
                <td colspan="7">
                    <?php echo "<div class='error'> There Is No Food Added Yet . </div>"; ?>
                </td>
            <?php
            }


            ?>
        </table>
    </div>
    <!-- End Main Content Section -->

<?php include('partials/footer.php'); ?>