<?php
    ob_start(); // Turns on output buffering
    session_start();

    $timezone = date_default_timezone_set("Asia/Dhaka");

    $con = mysqli_connect('localhost', 'root', '', 'social');

    if (mysqli_connect_errno()) {
        echo "Faild to connect: " . mysqli_connect_errno();
    }

?>