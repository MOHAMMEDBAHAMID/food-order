<?php include('partials-front/menu.php'); ?>

<!-- fOOD sEARCH Section Starts Here -->
<section class="food-search text-center">
    <div class="container">

        <?php
        // Getting Serach Value
        $search = mysqli_real_escape_string($conn,$_POST['search']);
        ?>

        <h2>Foods on Your Search <a href="#" class="text-white">"<?php echo $search; ?>"</a></h2>

    </div>
</section>
<!-- fOOD sEARCH Section Ends Here -->



<!-- fOOD MEnu Section Starts Here -->
<section class="food-menu">
    <div class="container">
        <h2 class="text-center">Food Menu</h2>

        <?php
        // Create Sql Query 
        $sql = "SELECT * FROM tbl_food WHERE title LIKE '%$search%' OR description LIKE '%$search%'";
        // Execute The Query 
        $res = mysqli_query($conn, $sql);
        // Check Whether Query Executed Or Not 
        if ($res == true) {
            // Count The Rows To Check Whether We Have Data Or Not
            $count = mysqli_num_rows($res);
            if ($count > 0) {
                // Means We Have Data
                while ($row = mysqli_fetch_assoc($res)) {
                    $id = $row['id'];
                    $title = $row['title'];
                    $description = $row['description'];
                    $price = $row['price'];
                    $image_name = $row['image_name'];
        ?>

                    <div class="food-menu-box">
                        <div class="food-menu-img">
                            <?php
                            // Check Whether Food Has Image Or Not
                            if ($image_name != '') {
                                // Display The Image
                            ?>
                                <img src="<?php echo SITEURL;?>images/food/<?php echo $image_name;?>" alt="Chicke Hawain Pizza" class="img-responsive img-curve">

                            <?php
                            } else {
                                // Display Message
                                echo '<div class="error">Image Not Available . </div>';
                            }

                            ?>
                        </div>

                        <div class="food-menu-desc">
                            <h4><?php echo $title; ?></h4>
                            <p class="food-price"><?php echo $price ?></p>
                            <p class="food-detail">
                                <?php echo $description; ?>
                            </p>
                            <br>

                            <a href="<?php SITEURL;?>order.php?food_id=<?php echo $id;?>" class="btn btn-primary">Order Now</a>
                        </div>
                    </div>


        <?php

                }
            } else {
                echo '<div class="error"> There Is No Food . </div>';
            }
        }

        ?>



        <div class="clearfix"></div>



    </div>

</section>
<!-- fOOD Menu Section Ends Here -->

<?php include('partials-front/footer.php'); ?>