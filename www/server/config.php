<?php
$servername = 'localhost';
$username = 'root';
$password = '';
$myDB = 'capstoneDatabase';

// Create connection
$conn = new mysqli($servername, $username, $password, $myDB);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$version = time();
//$version = 1.3;

//echo "Connected successfully"; // for connected successfully


?>