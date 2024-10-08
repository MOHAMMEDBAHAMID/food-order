<?php include('partials/menu.php') ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Change Password</h1>
        <br> <br>

        <?php
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
        }
        ?>

        <form action="" method="post">
            <table>
                <tr>
                    <td>Current Password: </td>
                    <td>
                        <input type="password" name="current_password" placeholder="Current Password">
                    </td>
                </tr>

                <tr>
                    <td>New Password: </td>
                    <td>
                        <input type="password" name="new_password" placeholder="New Password">
                    </td>
                </tr>

                <tr>
                    <td>Confirm Password: </td>
                    <td>
                        <input type="password" name="confirm_password" placeholder="Confirm Password">
                    </td>
                </tr>

                <tr>
                    <td>
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="submit" name="submit" value="Change Password" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>


<?php

// Check Whether The Submit Clicked Or Not 
if (isset($_POST['submit'])) {

    // 1.Get The Data From The Form
    $id = $_POST['id'];
    $current_password = md5($_POST['current_password']);
    $new_password = md5($_POST['new_password']);
    $confirm_password = md5($_POST['confirm_password']);

    // 2.Check Whether The User With Current Id And Current Password Exists Or Not
    $sql = "SELECT * FROM tbl_admin WHERE id = $id AND password = '$current_password'";
    // Execute The Query 
    $res = mysqli_query($conn, $sql);

    if ($res == TRUE) {
        // Check Whether Data Is Available Or Not
        $count = mysqli_num_rows($res);

        if ($count == 1) {
            // User Exists And Password Can Be Change

            if ($new_password == $confirm_password) {
                // Update Password
                $sql2 = "UPDATE tbl_admin SET
                                password = '$new_password'
                                WHERE id = $id
                            ";
                // Execute The Query 
                $res2 = mysqli_query($conn, $sql2);

                // Check Whether The Query Executed Or Not
                if ($res2 == true) {

                    // Display Success Message 
                    $_SESSION['change-pwd'] = '<div class="success"> Password Changed Successfully. </div>';
                    header('location:' . SITEURL . 'admin/manage-admin.php');
                } else {

                    // Display Error Message
                    $_SESSION['change-pwd'] = '<div class="error"> Failed To Change Password . </div>';
                    header('location:' . SITEURL . 'admin/manage-admin.php');
                }
            } else {
                // Redirect To manage Admin Page
                $_SESSION['pwd-not-match'] = '<div class="error"> Password Not Match. </div>';
                header('location:' . SITEURL . 'admin/manage-admin.php');
            }
        } else {
            // User Not Exists Set Message And Redirect
            $_SESSION['user-not-found'] = '<div class="error"> User Not Found. </div>';
            header('location:' . SITEURL . 'admin/manage-admin.php');
        }
    }



    // 4.Change Password If Above Is Ture
}
?>

<?php include('partials/footer.php') ?>