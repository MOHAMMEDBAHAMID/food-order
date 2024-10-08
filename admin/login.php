<?php include('../config/constants.php'); ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login </title>
    <link rel="stylesheet" href="../css/admin.css">
</head>

<body>

    <div class="login">
        <h1 class="text-center">Login</h1>
        <br><br>
        <?php
        if (isset($_SESSION['login'])) {
            echo $_SESSION['login'];
            unset($_SESSION['login']);
        }

        if (isset($_SESSION['no-login-message'])) {
            echo $_SESSION['no-login-message'];
            unset($_SESSION['no-login-message']);
        }
        ?>

        <br><br>

        <!-- Login Form Starts -->
        <form action="" method="post" class="text-center"><br>
            Username : <br>
            <input type="text" name="username" placeholder="Enter Your Username"><br><br>

            Password : <br>
            <input type="password" name="password" placeholder="Enter Your Password"><br><br>
            <input type="submit" name="submit" value="Login" class="btn-primary">

        </form>
        <!-- Login Form Ends -->
    </div>
</body>

</html>

<?php

// Check Whether The Submot Button Is Clicked Or Not

if (isset($_POST['submit'])) {
    // 1.Get The Data From The Form
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = md5($_POST['password']);

    // 2.Sql Query To Check Whether Username Exists Or Not
    $sql = "SELECT * FROM tbl_admin WHERE username='$username'  AND password ='$password'";

    // 3.Execute The Query 
    $res = mysqli_query($conn, $sql);
    // For testing 
    // $row = mysqli_fetch_assoc($res);
    // echo $row;


    // echo $res;
    // var_dump($res);

    // 4.Count Rows To Check Whether The User Exists Or Not 
    $count = mysqli_num_rows($res);

    if ($count == 1) {
        // User Available And Login Success
        $_SESSION['login'] = "<div class='success text-center'>Login Successful. </div>";
        $_SESSION['user'] = $username; //To Check Whether user Logged in Or Not 
        // Redirect To Home Page Dashboard
        header('location:' . SITEURL . 'admin/');
    } else {
        // User Not Available And Login Failed
        $_SESSION['login'] = "<div class='error text-center'>Username Or Password Did Not Match. </div>";
        // Redirect To Home Page Dashboard
        header('location:' . SITEURL . 'admin/login.php');
    }
}
?>