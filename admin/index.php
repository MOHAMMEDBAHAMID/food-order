<?php include('partials/menu.php') ?>
<!-- Start Main Content Section -->
<div class="main-content">
    <div class="wrapper">
        <h1>DASHBOARD</h1>
        <br><br>
        <?php
        if (isset($_SESSION['login'])) {
            echo $_SESSION['login'];
            unset($_SESSION['login']);
        }
        ?>

        <br><br>
        <div class="container">

            <div class="col-4 text-center">
                <?php
                // Sql Query 
                $sql = "SELECT * FROM tbl_category";
                // Execute The Query
                $res = mysqli_query($conn,$sql);
                // Count Rows 
                $count = mysqli_num_rows($res);
                ?>
                <h1><?php echo $count;?> </h1>
                <br>
                categories
            </div>

            <div class="col-4 text-center">
            <?php
                // Sql Query 
                $sql2 = "SELECT * FROM tbl_food";
                // Execute The Query
                $res2 = mysqli_query($conn,$sql2);
                // Count Rows 
                $count2 = mysqli_num_rows($res2);
                ?>
                <h1><?php echo $count2;?></h1>
                <br>
                Foods
            </div>

            <div class="col-4 text-center">
            <?php
                // Sql Query 
                $sql3 = "SELECT * FROM tbl_order";
                // Execute The Query
                $res3 = mysqli_query($conn,$sql3);
                // Count Rows 
                $count3 = mysqli_num_rows($res3);
                ?>
                <h1><?php echo $count3;?></h1>
                <br>
                Total Orders 
            </div>

            <div class="col-4 text-center">
                <?php 
                // Create Sql Query To Get Total Revenue Generated
                // Aggregate Function In Sql
                $sql4 = "SELECT sum(total) AS Total FROM tbl_order WHERE status='Delivered'";
                // Execute The Query
                $res4 = mysqli_query($conn,$sql4);
                // Get The Total Revenue 
                $row4 = mysqli_fetch_assoc($res4);

                // Get The Total Revenue 
                $total_rev = $row4['Total'];

                ?>

                <h1>$ <?php echo $total_rev;?></h1>
                <br>
                Revenue Generated
            </div>
        </div>


    </div>
</div>
<!-- End Main Content Section -->

<?php include('partials/footer.php') ?>