<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
include("conn.php");

session_start();

if (isset($_SESSION['Username'])) {

    $UserName = $_SESSION['Username'];

    $sql = "DELETE FROM Notifications WHERE username = '$UserName'";
    $sql2 = "DELETE FROM User WHERE username = '$UserName'";
    // $sql3 = "DELETE FROM Donations WHERE username = '$UserName'";


    $rs = mysqli_query($con, $sql);

    $rs2 = mysqli_query($con, $sql2);

    // $rs2 = mysqli_query($con, $sql3);

    if ($rs && $rs2) {
        header("Location: login.php?lang=" . $lang);
      } else {
        echo "Error deleting record: " . $conn->error;
      }

}

?>