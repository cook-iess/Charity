<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
include("conn.php");

session_start();

// Check if username is provided in the URL
if (isset($_GET['id'])) {
    // Sanitize the id retrieved from the URL
    $UserName = mysqli_real_escape_string($con, $_GET['id']);

    // Prepare SQL statements to delete notifications and user
    $sql = "DELETE FROM Notifications WHERE username = '$UserName'";
    $sql2 = "DELETE FROM User WHERE username = '$UserName'";
    // $sql3 = "DELETE FROM Donations WHERE username = '$UserName'"; // Uncomment if needed

    // Execute the queries
    $rs = mysqli_query($con, $sql);
    $rs2 = mysqli_query($con, $sql2);
    // $rs3 = mysqli_query($con, $sql3); // Uncomment if needed

    // Check if the delete operations were successful
    if ($rs && $rs2) {
        header("Location: users.php"); // Redirect after deletion
        exit();
    } else {
        echo "Error deleting record: " . mysqli_error($con); // Use mysqli_error for the current connection
    }
} else {
    echo "No username provided.";
}

?>