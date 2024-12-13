<?php
session_start();
include("conn.php"); // Include your database connection

if (isset($_GET['id'])) {
    $notificationId = intval($_GET['id']);

    $updateQuery = "UPDATE fNotification SET is_read = 1 WHERE id = $notificationId";
    mysqli_query($con, $updateQuery);
}

// Redirect back to notifications page
header("Location: findex.php");
exit();
?>