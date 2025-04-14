<?php
$servername = "localhost";
$username = "root";
$password = "";


$conn = mysqli_connect($servername, $username, $password);


if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}


$dbname = "eavesdb";
$sql_create_db = "CREATE DATABASE IF NOT EXISTS $dbname";
if ($conn->query($sql_create_db) === TRUE) {
   
    $conn->select_db($dbname);
} else {
    die("Error creating database: " . $conn->error);
}

$sql = file_get_contents(__DIR__ . '/../database/eavesdb.sql');


if ($conn->multi_query($sql)) {
    echo "<h2>Database setup completed successfully!</h2>";
    echo "<p>The database has been created and initialized with sample data.</p>";
    echo "<p><a href='../index.php'>Go to homepage</a></p>";
} else {
    echo "Error: " . $conn->error;
}

$conn->close();
?> 