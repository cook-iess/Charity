<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
include("conn.php");

session_start();

if (isset($_SESSION['orgName'])) {

    $OrgName = $_SESSION['orgName'];
    $id = isset($_GET['id']) ? $_GET['id'] : '';

    $sql = "DELETE FROM Charity WHERE id = '$id'";
    // $sql2 = "DELETE FROM Donations WHERE orgId = '$id'";

    $rs = mysqli_query($con, $sql);

    // $rs2 = mysqli_query($con, $sql2);

    if ($rs) {
        header("Location: findex.php?lang=" . $lang);
      } else {
        echo "Error deleting record: " . $conn->error;
      }

}

?>