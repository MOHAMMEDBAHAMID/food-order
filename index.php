<?php include('partials-front/menu.php'); ?>

<!-- fOOD sEARCH Section Starts Here -->
<section class="food-search text-center">
    <div class="container">

        <form action="<?php echo SITEURL;?>food-search.php" method="POST">
            <input type="search" name="search" placeholder="Search for Food.." required>
            <input type="submit" name="submit" value="Search" class="btn btn-primary">
        </form>

    </div>
</section>
<!-- fOOD sEARCH Section Ends Here -->
<?php 
if(isset($_SESSION['order'])){
    echo $_SESSION['order'];
    unset($_SESSION['order']);
}

?>
<!-- CAtegories Section Starts Here -->
<section class="categories">
    <div class="container">
        <h2 class="text-center">Explore Foods</h2>

        <?php
        // Create Sql Query 
        $sql = "SELECT * FROM tbl_category WHERE active ='Yes' AND featured='Yes' LIMIT 3";
        // Execute The Query
        $res = mysqli_query($conn, $sql);

        // Check Whether Query Executed Or Not
        if ($res == true) {
            // Check Whether We Have Data Or Not
            // Conut The Rows
            $count = mysqli_num_rows($res);
            if ($count > 0) {
                // WE Have Categories
                // Get The Data From Databse
                while ($row = mysqli_fetch_assoc($res)) {
                    $id = $row['id'];
                    $title = $row['title'];
                    $image_name = $row['image_name'];
        ?>

                    <a href="<?php SITEURL;?>category-foods.php?category_id=<?php echo $id;?>">
                        <div class="box-3 float-container">
                            <?php
                            // Check Whether Category Has Image Or Not
                            if ($image_name == '') {
                                echo '<div class="error">Image Not Available . </div>';
                            } else {
                            ?>
                                <img src="<?php echo SITEURL; ?>images/category/<?php echo $image_name; ?>" alt="Pizza" class="img-responsive img-curve">

                            <?php

                            }
                            ?>


                            <h3 class="float-text text-white"><?php echo $title; ?></h3>
                        </div>
                    </a>

        <?php
                }
            } else {
                // We Don't Have Categories
                echo '<div class="error">There is No Category Yet</div>';
            }
        } else {
        }

        ?>



        <div class="clearfix"></div>
    </div>
</section>
<!-- Categories Section Ends Here -->

<!-- fOOD MEnu Section Starts Here -->
<section class="food-menu">
    <div class="container">
        <h2 class="text-center">Food Menu</h2>

        <?php
        // Create Sql Query To Get The Data From Database
        $sql2 = "SELECT * FROM tbl_food WHERE featured ='Yes' AND active ='Yes' LIMIT 6";
        // Execute The Query
        $res2 = mysqli_query($conn, $sql2);

        if ($res == true) {
            // Query Executed 
            // Count The Rows To Check Whether We Have Foods Or Not 
            $count2 = mysqli_num_rows($res2);
            if ($count2 > 0) {
                // Getting The Data 
                while ($row = mysqli_fetch_assoc($res2)) {
                    $id = $row['id'];
                    $title = $row['title'];
                    $description = $row['description'];
                    $price = $row['price'];
                    $image_name = $row['image_name'];

        ?>

                    <div class="food-menu-box">
                        <div class="food-menu-img">

                        <?php
                        // Check Wether Image Is Available Or Not 
                        if($image_name == ''){
                            // Image Is Not Available
                            echo '<div class="error">Image Not Available . </div>';
                        }else{
                            // Image Available
                            ?>
                            <img src="<?php echo SITEURL;?>images/food/<?php echo $image_name;?>" alt="Chicke Hawain Pizza" class="img-responsive img-curve">

                            <?php
                        }
                        ?>
                        </div>

                            

                        <div class="food-menu-desc">
                            <h4><?php echo $title;?></h4>
                            <p class="food-price">$<?php echo $price;?> </p>
                            <p class="food-detail">
                            <?php echo $description;?>
                            </p>
                            <br>

                            <a href="<?php SITEURL;?>order.php?food_id=<?php echo $id;?>" class="btn btn-primary">Order Now</a>
                        </div>
                    </div>
        <?php

                }
            } else {
                // We Don't Have Foods
                echo '<div class="error">There is No Category Yet</div>';
            }
        }

        ?>





        <div class="clearfix"></div>



    </div>

    <p class="text-center">
        <a href="#">See All Foods</a>
    </p>
</section>
<!-- fOOD Menu Section Ends Here -->

<?php include('partials-front/footer.php'); ?>