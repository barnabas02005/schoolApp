<?php
include("config_json.php");
include("function_room.php");

$data = json_decode(file_get_contents("php://input"), true);

$firstname = $data['firstname'];
$lastname = $data['lastname'];
$class = $data['classs'];
$gender = $data['gender'];
$password = hashString($data['password']);

$sql = "INSERT INTO student (firstname, lastname, class, gender, `password`, `status`, date_added) VALUES (?, ?, ?, ?, ?, 1, NOW())";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "ssiis", $firstname, $lastname, $class, $gender, $password);

if (mysqli_stmt_execute($stmt)) {
  echo json_encode(["message" => "Student added successfully with hashed password."]);
} else {
  echo json_encode(["message" => "Error: " . mysqli_error($conn)]);
}

mysqli_stmt_close($stmt);
mysqli_close($conn);
