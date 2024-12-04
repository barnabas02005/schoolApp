<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
header("Content-Type: application/json");

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "classhelp";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
  die(json_encode(["message" => "Connection failed: " . mysqli_connect_error()]));
}
