<?php include('partials/menu.php') ?>
<div class="main-content">
    <div class="wrapper">
        <h1>Add Admin</h1>
        <br> <br> <br>

        <?php 
            if(isset($_SESSION['add'])){
                echo $_SESSION['add'];
                unset($_SESSION['add']);
            }
        ?>

        <form action="" method="POST">
            <table class="tbl-30">
                <tr>
                    <td>Full Name:</td>
                    <td>
                        <input type="text" name="full_name" placeholder="Enter Your Name">
                    </td>
                </tr>
                <tr>
                    <td>Username:</td>
                    <td>
                        <input type="text" name="username" placeholder="Enter Your Username">
                    </td>
                </tr>
                <tr>
                    <td>Password:</td>
                    <td>
                        <input type="password" name="password" placeholder="Enter Your Password">
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Admin" class="btn-secondary">
                    </td>
                </tr>

            </table>
        </form>
    </div>
</div>

<?php include('partials/footer.php') ?>

<?php
if (isset($_POST['submit'])) {
    
    //1. Get The Data From Form
    $full_name = $_POST['full_name'];
    $username = $_POST['username'];
    $password = md5($_POST['password']); //Password Encryption with MD5

    //2. Sql Query To Save The Data Tnto Database
    $sql = "INSERT INTO tbl_admin SET
    full_name = '$full_name',
    username = '$username',
    password = '$password' 
    ";

   //3. Executing Query And Saving Data Into Database
   $res = mysqli_query($conn,$sql) or die(mysqli_error($conn));

   //4. Chek wether the (Query Is Executed)
    if($res==TRUE){
        // Data Inserted
        // echo 'Data Inserted';
        //Create A Session Variable To Display Message  
        $_SESSION['add'] = '<div class="added">Admin Added Succesfully</div>';
        // Redirect Page To Manage Admin
        header('location:'.SITEURL.'admin/manage-admin.php');
    }else{
        // Faild To Insert Data
        // echo 'Faild To Insert Data';
                //Create A Session Variable To Display Message  
                $_SESSION['add'] = 'Failed To Add Admin';
                // Redirect Page To Manage Admin
                header('location:'.SITEURL.'admin/add-admin.php');
    }

}
?>