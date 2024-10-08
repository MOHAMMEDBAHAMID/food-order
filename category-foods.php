<?php include('partials-front/menu.php'); ?>
<?php
// Check Whether We Get Th Category ID Or Not
if (isset($_GET['category_id'])) {

    $category_id = $_GET['category_id'];

    // Create Sql Query To Get The Title Based On Catory Id
    $sql = "SELECT title FROM tbl_category WHERE id = $category_id ";
    // Execute The Query 
    $res = mysqli_query($conn, $sql);

    $row = mysqli_fetch_assoc($res);
    $category_title = $row['title'];
} else {
    // Redirect To Home Page
    header('location:' . SITEURL);
}
?>

<!-- fOOD sEARCH Section Starts Here -->
<section class="food-search text-center">
    <div class="container">

        <h2>Foods on <a href="#" class="text-white">"<?php echo $category_title; ?>"</a></h2>

    </div>
</section>
<!-- fOOD sEARCH Section Ends Here -->



<!-- fOOD MEnu Section Starts Here -->
<section class="food-menu">
    <div class="container">
        <h2 class="text-center">Food Menu</h2>

        <?php 
        // Create Sql Query To Get The Data 
        $sql2 = "SELECT * FROM tbl_food WHERE category_id = $category_id";
        // Execute The Query 
        $res2 = mysqli_query($conn,$sql2);

        // Chech whether Query Excuted Or Not 
        if($res2 == true){
            // Count The Rows To Know Whether There Data To Display Or Not
            $count2 = mysqli_num_rows($res2);
            if($count2 > 0 ){
                // There Is Data Available
                while($row = mysqli_fetch_assoc($res2)){
                    // Getting The Data
                    $id = $row['id'];
                    $title = $row['title'];
                    $description = $row['description'];
                    $price = $row['price'];
                    $image_name = $row['image_name'];
                    ?>

                    
                     <!-- Display The Data -->

                    <div class="food-menu-box">
                    <div class="food-menu-img">
                        <?php 
                        // Check Wether Image Availalble Or Not 
                        if($image_name != ''){
                            // Image Available
                            ?>
                        <img src="<?php echo SITEURL;?>images/food/<?php echo $image_name;?>" alt="Chicke Hawain Pizza" class="img-responsive img-curve">
                        <?php

                        }else{
                            // Image Not Available
                            echo '<div class="error">Image Not Available . </div>';

                        }
                        ?>
                    </div>
        
                    <div class="food-menu-desc">
                        <h4><?php echo $title;?></h4>
                        <p class="food-price"><?php echo $price; ?></p>
                        <p class="food-detail">
                            <?php echo $description; ?>
                        </p>
                        <br>
        
                        <a href="<?php SITEURL;?>order.php?food_id=<?php echo $id;?>" class="btn btn-primary">Order Now</a>
                    </div>
                </div>

                <?php
                }


            }else{
                // There Is No Data Available 
                echo '<div class="error">There is No Food Available . </div>';
            }
        }


        ?>





        <div class="clearfix"></div>



    </div>

</section>
<!-- fOOD Menu Section Ends Here -->

<?php include('partials-front/footer.php'); ?>