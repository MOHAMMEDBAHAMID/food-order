<?php include('partials/menu.php') ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Update Admin</h1>
        <br><br>

        <?php
        // 1.Get The Id Of Seleceted Admin
        $id = $_GET['id'];
        // 2.Create Sql Query to Update The Admin
        $sql = "SELECT * FROM tbl_admin WHERE id = $id";
        // 3.Execting The Query 
        $res = mysqli_query($conn, $sql);

        // Check Whether The Query Excuted Or Not
        if ($res == TRUE) {
            // Check Whether The Data Is Available Or Not
            $count = mysqli_num_rows($res);
            // Check Whether We Have Admin Data Or Not
            if ($count == 1) {
                // Get The Details
                $row = mysqli_fetch_assoc($res);

                $full_name = $row['full_name'];
                $username = $row['username'];
            }
        }
        ?>

        <form action="" method="POST">
            <table>
                <tr>
                    <td>Full Name: </td>
                    <td><input type="text" name="full_name" value="<?php echo $full_name; ?>"></td>
                </tr>
                <tr>
                    <td>Username: </td>
                    <td><input type="text" name="username" value="<?php echo $username; ?>"></td>
                </tr>
                <tr>

                    <td colspan="2">
                        <input type="hidden" name="id" value="<?php echo $id ?>">
                        <input type="submit" name="submit" value="Update Admin" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>

<?php

if (isset($_POST['submit'])) {

    // Get The Values From The Form To Update
    $id = $_POST['id'];
    $full_name = $_POST['full_name'];
    $username = $_POST['username'];

    // Create Sql Query 
    $sql = "UPDATE tbl_admin SET
    full_name = '$full_name',
    username = '$username'
    WHERE id = $id
    ";

    // Execute The Query 
    $res = mysqli_query($conn,$sql);

    // Check Whether Query Executed Or Not
    if($res == TRUE){
        $_SESSION['update'] = '<div class="success">Admin Updated Successfully</div>';
        header('location:'.SITEURL.'admin/manage-admin.php');
    }else{
        $_SESSION['update'] = '<div class="error"> Failed To Update Admin</div>';
        header('location:'.SITEURL.'admin/manage-admin.php');
    }

}
?>

<?php include('partials/footer.php') ?>