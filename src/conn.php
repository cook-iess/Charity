<?php
error_reporting(E_ALL); 
ini_set('display_errors', 1);
$con=mysqli_connect("localhost","root","");
$db=mysqli_select_db($con, "Charity");
if(!$con){
    echo "connection failed";
    exit();
}
?>