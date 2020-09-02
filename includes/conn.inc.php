<?php 

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "all_in_one_app_db";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
	die("Connection failed: " . mysqli_connect_error());
}
