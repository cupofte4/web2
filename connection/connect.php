<?php
$servername = "localhost";
$dbname = "eavesdb";
$username = "root";
$password = "";
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>