<?php include('partials/menu.php') ?>
<!-- Start Main Content Section -->
<div class="main-content">
    <div class="wrapper">
        <h1>Mange Admin</h1>
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

        if (isset($_SESSION['update'])) {
            echo $_SESSION['update'];
            unset($_SESSION['update']);
        }

        if (isset($_SESSION['user-not-found'])) {
            echo $_SESSION['user-not-found'];
            unset($_SESSION['user-not-found']);
        }

        if (isset($_SESSION['pwd-not-match'])) {
            echo $_SESSION['pwd-not-match'];
            unset($_SESSION['pwd-not-match']);
        }

        if (isset($_SESSION['change-pwd'])) {
            echo $_SESSION['change-pwd'];
            unset($_SESSION['change-pwd']);
        }
        ?>
        <br> <br> <br>

        <a href="add-admin.php" class="btn-primary">Add Admin</a>
        <br> <br> <br>
        <table class="tbl-full">
            <tr>
                <th>S.N.</th>
                <th>Full Name</th>
                <th>Username</th>
                <th>Actions</th>
            </tr>

            <?php
            // Query To Get All Admin 
            $sql = 'SELECT * FROM tbl_admin';
            // Executing The Query 
            $res = mysqli_query($conn, $sql);

            // Check Whether The Query Is Executed Or Not 
            if ($res == TRUE) {
                // Count Rows To Check whether We Have Data In Database Or Not
                $count = mysqli_num_rows($res); // Function To Get The Number Of Rows In Database
                $sn = 1;
                // Check The Num Of Rows 
                if ($count > 0) {
                    // We Have Data In Our Database
                    while ($rows = mysqli_fetch_assoc($res)) {
                        /*Using While loop To Get All Data From Database
                            And While loop Will As Long As We Have Data 
                            */

                        // Get Individual Data
                        $id = $rows['id'];
                        $full_name = $rows['full_name'];
                        $username = $rows['username'];

                        // Display The Values In Table
            ?>
                        <tr>
                            <td><?php echo $sn++; ?></td>
                            <td><?php echo $full_name; ?></td>
                            <td><?php echo $username; ?></td>
                            <td>
                                <a href="<?php echo SITEURL; ?>admin/update-admin.php? id=<?php echo $id; ?>" class="btn-secondary">Update Admin</a>
                                <a href="<?php echo SITEURL; ?>admin/delete-admin.php? id=<?php echo $id; ?>" class="btn-danger">Delete Admin</a>
                                <a href="<?php echo SITEURL; ?>admin/update-password.php? id=<?php echo $id; ?>" class="btn-primary">Change Password</a>

                            </td>
                        </tr>

            <?php

                    }
                } else {
                    // We Don't Have Data In Our Database
                }
            }
            ?>
        </table>
    </div>
    <!-- End Main Content Section -->

    <?php include('partials/footer.php') ?>