<?php
     // Start Session
     session_start();

     const SITEURL = 'http://localhost/food-order/';
     const LOCALHOST ='localhost';
     const DB_USERNAME = 'root';
     const DB_PASSWORD = '';
     const DB_NAME = 'food-order';
     
     $conn = mysqli_connect(LOCALHOST,DB_USERNAME,DB_PASSWORD) or die(mysqli_error($conn));
     $db_select = mysqli_select_db($conn,DB_NAME) or die(mysqli_error($conn));
     
?>