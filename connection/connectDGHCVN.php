<?php
$servername = "localhost";
$dbname = "diagioihanhchinhvn";
$username = "root";
$password = "";
$connDGHCVN = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$connDGHCVN) {
    die("Connection failed: " . mysqli_connect_error());
}
?>