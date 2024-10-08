<?php include('partials-front/menu.php'); ?>

<?php
// Check Whether Id Is Set Or Not
if (isset($_GET['food_id'])) {
    // Getting The Details Of The Food
    $food_id = $_GET['food_id'];

    $sql = "SELECT * FROM tbl_food WHERE id = $food_id";
    $res = mysqli_query($conn, $sql);

    if ($res == true) {
        // Count The Data To Check The Order In Our Case Count Should Be 1 
        $count = mysqli_num_rows($res);
        if ($count == 1) {
            while ($row = mysqli_fetch_assoc($res)) {
                $title = $row['title'];
                $price = $row['price'];
                $image_name = $row['image_name'];
            }
        } else {
            // Redirect To Home Pgae
            header('location:' . SITEURL);
        }
    }
} else {
    // Redirect TO Home Page
    header('location:' . SITEURL);
}
?>

<!-- fOOD sEARCH Section Starts Here -->
<section class="food-search">
    <div class="container">

        <h2 class="text-center text-white">Fill this form to confirm your order.</h2>

        <form action="" method="POST" class="order">
            <fieldset>
                <legend>Selected Food</legend>

                <div class="food-menu-img">
                    <?php
                    if ($image_name == '') {
                        // Image Is Not Available
                        echo '<div class="error">Image Not Available . </div>';
                    } else {
                        // Image Is Available
                    ?>
                        <img src="<?php echo SITEURL; ?>images/food/<?php echo $image_name; ?>" alt="Chicke Hawain Pizza" class="img-responsive img-curve">
                    <?php

                    }

                    ?>
                </div>

                <div class="food-menu-desc">
                    <h3><?php echo $title; ?></h3>
                    <input type="hidden" name="food" value="<?php echo $title; ?>">
                    <p class="food-price">$<?php echo $price; ?></p>
                    <input type="hidden" name="price" value="<?php echo $price; ?>">


                    <div class="order-label">Quantity</div>
                    <input type="number" name="qty" class="input-responsive" value="1" required>

                </div>

            </fieldset>

            <fieldset>
                <legend>Delivery Details</legend>
                <div class="order-label">Full Name</div>
                <input type="text" name="full-name" placeholder="Please Enter Your Full Name" class="input-responsive" required>

                <div class="order-label">Phone Number</div>
                <input type="tel" name="contact" placeholder="Please Enter Your Phone Number" class="input-responsive" required>

                <div class="order-label">Email</div>
                <input type="email" name="email" placeholder="Please Enter Your Email" class="input-responsive" required>

                <div class="order-label">Address</div>
                <textarea name="address" rows="10" placeholder="E.g. Street, City, Country  " class="input-responsive" required></textarea>

                <input type="submit" name="submit" value="Confirm Order" class="btn btn-primary">
            </fieldset>

        </form>

        <?php
        if (isset($_POST['submit'])) {
            // Get The Details From The Form
            $food = $_POST['food'];
            $price = $_POST['price'];
            $qty = $_POST['qty'];

            $total = $price * $qty;

            $order_date = date("Y-m-d h:i:sa");

            $status = "Ordered"; //Ordered , On Delivery , Delivered , Cancelled

            $customer_name= $_POST['full-name'];
            $customer_contact = $_POST['contact'];
            $customer_email = $_POST['email'];
            $customer_address = $_POST['address'];

            // Create Sql Query 
            $sql2 = "INSERT INTO tbl_order SET
            food = '$food',
            price = $price,
            qty = $qty,
            total = $total,
            order_date = '$order_date',
            status = '$status',
            customer_name = '$customer_name',
            customer_contact = '$customer_contact',
            customer_email = '$customer_email',
            customer_address = '$customer_address'
            ";

            // echo $sql2 ;
            // die();
            
            // Execute The Query 
            $res2 = mysqli_query($conn,$sql2);

            if($res2 == true){
                // Order Added Successfully .
                $_SESSION['order'] = '<div class="success">Food Ordered Successfully .</div>';
                header('location:'.SITEURL);
            }else{
                // Failed To Order
                $_SESSION['order'] = '<div class="success">Failed To Order Food .</div>';
                header('location:'.SITEURL);
            }
        }

        ?>

    </div>
</section>
<!-- fOOD sEARCH Section Ends Here -->

<?php include('partials-front/footer.php'); ?>