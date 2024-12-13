<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
include("conn.php");

session_start();

if (isset($_SESSION['orgName'])) {

    $orgName = $_SESSION['orgName'];

    $sql2 = "DELETE FROM Charity WHERE orgName = '$orgName'";
    $sql3 = "DELETE FROM Organization WHERE orgName = '$orgName'";


    $rs2 = mysqli_query($con, $sql2);

    $rs3 = mysqli_query($con, $sql3);


    if ($rs2 && $rs3) {
        header("Location: flogin.php?lang=" . $lang);
      } else {
        echo "Error deleting record: " . $conn->error;
      }

}

?>