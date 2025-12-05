<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cricketdb";

// Create connection
$conn = mysqli_connect("localhost", "root", "", "cricketdb");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
