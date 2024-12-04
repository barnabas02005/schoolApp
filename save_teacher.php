<?php
include("config_json.php");

$data = json_decode(file_get_contents("php://input"), true);

$firstname = htmlspecialchars($data['firstname']);
$lastname = htmlspecialchars($data['lastname']);
$gender = htmlspecialchars($data['gender']);
$title = htmlspecialchars($data['title']);
$passwordHash = htmlspecialchars($data['password_hash']);
$email = htmlspecialchars($data['email']);
$mobilenumber = htmlspecialchars($data['mobilenumber']);

$sql = "INSERT INTO teacher (firstname, lastname, gender, title, `password`, email, mobilenumber, `status`, date_added) VALUES (?, ?, ?, ?, ?, ?, ?, 1, NOW())";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "ssissss", $firstname, $lastname, $gender, $title, $passwordHash, $email, $mobilenumber);

if (mysqli_stmt_execute($stmt)) {
  echo json_encode(["message" => "Teacher added successfully with hashed password."]);
} else {
  echo json_encode(["message" => "Error: " . mysqli_error($conn)]);
}

mysqli_stmt_close($stmt);
mysqli_close($conn);
