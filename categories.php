<?php include('partials-front/menu.php'); ?>


<!-- CAtegories Section Starts Here -->
<section class="categories">
    <div class="container">
        <h2 class="text-center">Explore Foods</h2>

        <?php
        // Create Sql Query 
        $sql = "SELECT * FROM tbl_category WHERE active ='YES'";
        // Execute The Query 
        $res = mysqli_query($conn, $sql);

        // Check Whether Query Exeuted Or Not
        if ($res == true) {
            // Executed
            // Count The Rows To Check Whether We Have Categories Or Not
            $count = mysqli_num_rows($res);
            if ($count > 0) {
                // Means We Have Categories
                while ($row = mysqli_fetch_assoc($res)) {
                    $id = $row['id'];
                    $title = $row['title'];
                    $image_name = $row['image_name'];

        ?>

                    <a href="<?php SITEURL;?>category-foods.php?category_id=<?php echo $id;?>">
                        <div class="box-3 float-container">
                            <?php
                            // Check Whether The Category Has Image Or Not 
                            if($image_name != ''){
                                // Has Image
                                ?>
                            <img src="<?php echo SITEURL;?>images/category/<?php echo $image_name;?>" alt="Pizza" class="img-responsive img-curve">


                                <?php

                            }else{
                                // Doesn't Have Image
                                echo '<div class="error">Image Not Available . </div>';
                            }
                            ?>
                            
                            <h3 class="float-text text-white"><?php echo $title; ?></h3>
                        </div>
                    </a>

        <?php
                }
            } else {
                echo '<div class="error">There Is No Category Added Yet . </div>';
            }
        }


        ?>




        <div class="clearfix"></div>
    </div>
</section>
<!-- Categories Section Ends Here -->

<?php include('partials-front/footer.php'); ?>