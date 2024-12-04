<?php
include("config_json.php");

$data = json_decode(file_get_contents("php://input"), true);

$classname = $data['classname'];
$passwordHash = $data['password_hash'];

$sql = "INSERT INTO class (classname, `password`, `status`, date_added) VALUES (?, ?, 1, NOW())";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "ss", $classname, $passwordHash);

if (mysqli_stmt_execute($stmt)) {
  echo json_encode(["message" => "Class added successfully with hashed password."]);
} else {
  echo json_encode(["message" => "Error: " . mysqli_error($conn)]);
}

mysqli_stmt_close($stmt);
mysqli_close($conn);
